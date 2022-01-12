#!/usr/bin/phantomjs

/**
 * THIS SCRIPT IS INTENDED TO RUN WITH PHANTOMJS
 * ---------------------------------------------
 *
 * Note: if you use Ubuntu's repo phantom JS you will get an error
 * running this script. It is recommended to use the downloadable
 * version (see installation instructions below).
 *
 * Installation (Linux 64 bits):
 *
 *     wget https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-linux-x86_64.tar.bz2
 *     tar -xvf phantomjs-2.1.1-linux-x86_64.tar.bz2
 *     sudo mv phantomjs-2.1.1-linux-x86_64/bin/phantomjs /usr/bin/phantomjs
 *     rm -rf phantomjs-2.1.1-linux-x86_64 phantomjs-2.1.1-linux-x86_64.tar.bz2
 *
 * Usage:
 *
 *     urssaf.js <verification_key>
 *
 */

var page   = require('webpage').create();
var system = require('system');
var url    = "https://www.urssaf.fr/portail/home/utile-et-pratique/verification-attestation.html";

if (system.args.length != 2) {
    system.stderr.write("Missing verification key!\n\n");
    system.stderr.write("Usage: urssaf.js <verification_key>\n");
    phantom.exit(1);
}

var verification_key = system.args[1]; // PB9BESLD2VWI1PE

var parse_date = function(date) {
    var regex = /^(\d{2})\/(\d{2})\/(\d{4})/i;
    var found = date.match(regex);

    if (! found) {
        return null;
    }

    return found[3]+'-'+found[2]+'-'+found[1];
}

page.open(url, function(status) {
    // insert the key in form
    page.evaluate(function(verification_key) {
        var iframe = $('#Verifattestation');
        $('#codeAttestation', iframe.contents()).val(verification_key);
    }, verification_key);

    // submit the form (script on the page listens to 'submit')
    page.evaluate(function() {
        var iframe = $('#Verifattestation');
        $('#buttonAttest', iframe.contents()).trigger('click');
    });

    // wait 2s because the form uses AJAX
    // and then take a screenshot
    setTimeout(function() {
        var confirmation_key = page.evaluate(function () {
            var iframe = $('#Verifattestation');
            return $('#textNumero', iframe.contents()).text();
        });

        if (confirmation_key != verification_key) {
            system.stderr.write("Invalid verification key\n");
            return phantom.exit(1);
        }

        // take a screenshot
        var screenshot = "/tmp/urssaf-"+Date.now()+".png";
        page.viewportSize = {width: 1280, height: 1024};
        page.render(screenshot);

        // scrap the page
        var data = {
            verification_key: confirmation_key,

            nature: page.evaluate(function() {
                return $('#textNature').text();
            }),

            emitter: page.evaluate(function() {
                return $('#textEmetteur').text();
            }),

            certificationDate: parse_date(page.evaluate(function() {
                return $('#textDateCertif').text();
            })),

            companyName: page.evaluate(function() {
                return $('#textDenomination').text();
            }),

            companyEmployeesCount: page.evaluate(function() {
                return $('#textEffectif').text();
            }),

            companySalaryWeight: page.evaluate(function() {
                return $('#textMasseSalariale').text();
            }),

            period: page.evaluate(function() {
                return $('#textPeriode').text();
            }),

            siret: page.evaluate(function() {
                return $('#etabTable tr:nth-child(2) td:first').text();
            }),

            address: page.evaluate(function() {
                return $('#etabTable tr:nth-child(2) td:nth-child(2)').text();
            })
        };

        system.stdout.write(JSON.stringify({ screenshot: screenshot, data: data }));
        phantom.exit();
    }, 2000);
});
