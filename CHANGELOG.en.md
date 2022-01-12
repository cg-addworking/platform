<center><img height="100px" src="https://app.addworking.com/img/logo_addworking_vertical.png" alt="Addworking" align="right"></center>

# Addworking Platform

## Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),

### [Unreleased]
### [0.73.1]
#### Fixed
* fix: user invitation form phone number (#3792)
* fix: ignoring documents if the contract model has no parties #3789 (#3790)
* fix: creation addhoc line for outbound invoice #3762 (#3786)
  
#### Added
* feature: creating of the export section + puting vendor export in a queue #3721 (#3787)
* feature: contract model variable add some system variables #3767 (#3779)

### [0.73.0]
#### Fixed
* fix: search headquarter department corse #3761 (#3783)
* fix: fix the bug when exporting the tracking lines (#3773)
* fix: internationnal phone number on enterprise creation #3755 (#3780)
* fix: Adjust the policy on the Business+ #3763 (#3774)
* fix: export provider invoices #issue-3760 (#3777)

#### Changed
* feature: international phone number part 2 #3781 (#3782)
* feature: fill in by default the name of the variables #issue-3766 (#3778)
* feature: contract edit allow support to change signature dates #3764 (#3776)
  
#### Added
* feature: adding behat scenarios for calculating contract state #issue-3665 (#3750)

### [0.72.6]
#### Fixed
* fix: old outbound invoice menu entry for customer on passwork sogetrel page #3753 (#3754)

### [0.72.5]
#### Fixed
* fix: mission and mission tracking index for hybrid enterprise #3744 (#3752)

#### Changed
* feature: round only totals of inbound and outbound #3713 (#3730)
* feature: allow to manage the invoices without the addworking invoice  #3718 (#3732)
* feature: add procedure finished to yousign (#3751)

#### Removed
* chore: clean old billing system #3724 (#3749)

### [0.72.4]
#### Fixed
* fix: removing html validation from mission vendor select (#3747)

### [0.72.3]
#### Fixed
* fix: calculating the contract state when editing it #issue-3665 (#3707)

#### Changed
* feature: increasing the payment deadline #issue-3714 (#3742)
* feature: update state by document validation #3720 (#3739)
* feature: Check if inbound invoice item exists or not before creation #3717 (#3735)
* feature: change the validation rule for the two digits after the decimal point to 4 #3712 (#3728)
* feature: allow searching by contract name and external id only #3715 (#3727)
* infrastructure: moving foundation package content to platform #issue-3723 (#3738)
* infrastructure: moving foundation views into platform #issue-3723 (#3737)

#### Added
* feature: display an Airtable iframe #issue-3719 (#3734)
* feature: add an attribute "updated_by" where you have to save the uuid of the one who modifies inbound and outbound invoices #3722 (#3729)
* feature: linking a mission to a contract at its creation #issue-3674 (#3696)

### [0.72.2]
#### Fixed
* fix: german translations (#3736)
  
#### Added
* feature: adding create contract without model tests #3716 (#3731)

### [0.72.1]
#### Added
* feature: yousign webhook for contract #3726 (#3733)

### [0.72.0]
#### Fixed
* fix: fixing bug in german enterprise creation #3709 (#3711)

### [0.71.9]
#### Fixed
* fix: addworking logo file name (#3710)
  
#### Added
* feature: sign contract with Yousign #3610 (#3692)

### [0.71.8]
#### Fixed
* fix: changing status filter to state filter in contract index #issue-3665 (#3708)
* fix: repairing setContractState artisan command #issue-3665 (#3706)

### [0.71.7]
#### Fixed
* fix: fix edit contract parties #3704 (#3705)

### [0.71.6]
#### Added
* feature: adding access restriction to create contract feature + adding a new ACL #3693 (#3703)
* feature: adding amendment valid until date to contract parent date #3700 (#3702)

### [0.71.5]
#### Fixed
* fix: app_translation_DE_ViS_2021-01-14 (#3688)
* fix: block the upload of files in formats other than PDF in order to guarantee the rendering #issue-3668 (#3685)
* fix: translation edit variables #3667 (#3681)

#### Changed
* feature: change state to upload signed contract #3695 (#3701)
* feature: displaying beta word in contract menu entry #issue-3673 (#3687)

#### Added
* feature: duplicate a contract model #3669 (#3690)
* feature: adding signed_at date to the create contract without model form (#3699)
* feature: update contract without model form #3666 (#3689)
* feature: Allow a multi-company member to display the vendor's customers #issue-3655-1 (#3691)
* feature: adding the ability to edit the signatories of a contract #3671 (#3679)
* feature: adding country to enterprise creation #3611 (#3645)
* feature: making sure the link that allows to access the documents of a contract displays when needed #3672 (#3684)
* feature: app_translation_DE_ViS_2021-01-14 (#3686)

### [0.71.4]
#### Changed
* feature: deactivate automatic mail sended to vendor to complete his documents attached to contract #3682 (#3683)

#### Added
* feature: creation customer contract access from the contract index #3675 (#3676)
* feature: external id processing #3670 (#3677)
* feature: creating delete contract part use case #issue-3654 (#3664)

### [0.71.3]
#### Fixed
* fix: edit provider invoice #issue-3648 (#3659)
* fix: change benjamin's email address to that of the support on the error view #3656 (#3660)
* fix: removing the ability to generate a contract if it doesnt have a model #3614 (#3643)
* fix: the way we check if a contract is ready to generate or not (#3641)

#### Changed
* feature: Giving ability to support to upload a signed contract file when the contract has no contract part and no contract model and no parts (#3646)
* feature: using formgroup instead of html when creating an input file #3649 (#3658)
* feature: update the way we change the contract status depending on the curent day #3618 (#3644)

#### Added
* feature: adding zipcode and city to enterprise address value in contract variables #3650 (#3662)
* feature: add access to the contract template support index from the contract support index #3653 (#3661)
* feature: implementing contract state logic #issue-3617 (#3647)
* feature: once the contract has been generated pass the share into secondaire (#3657)
* feature: app_translation_AC_DE_2020-12-17 (#3642)
* feature: adding enterprise link on the contract views #3628 (#3634)
* feature: create yousign client #3609 (#3632)

### [0.71.2]
#### Changed
* feature: adding action link to contract list of enterprise as support #3627 (#3635)
* feature: except amendment to contract index #3581 (#3603)
* fix: edit contracts dashboard links for customer and vendor (#3605)

#### Fixed
* fix: pulling all enterprises if selected contract owner is addworking (#3639)
* fix: mooving back some of the translations keys where they belong (#3636)
* fix: check if contract model is not empty in show contract #3630 (#3633)
* fix: updating document status of inactive vendors #issue-3624 (#3626)

#### Added
* feature: adding deutsch language to app #3623 (#3638)
* feature: create test for create_amendment use case #3616 (#3631)

### [0.71.1]
#### Fixed
* fix: replace file_id to contract part

#### Added
* app_translation_DE_ViS_2020-01-06 (#3625)
* app_translation_DE_ViS_2020-01-05 (#3607)

### [0.71.0]
#### Fixed
* fix: amendment creation (#3600)

#### Changed
* feature: add system env vars to enable scheduler actions (#3606)
* chore: bump axios from 0.18.1 to 0.21.1 (#3604)
* feature: calculate fees in queue #3577 (#3601)
* chore: update changelogs for v0.70.4 (#3599)

### [0.70.4]
#### Fixed
* fix: increase process contract #3597 (#3598)
* feature: review the status selector in the contract index #3580 (#3589)
* feature: review button display conditions on show contract #3587 (#3594)
* fix: fix contract search (#3593)
* fix: deleting old contract parts when generating a contract #issue-3526 (#3590)
* fix: pluck name to select option in edit contract model #3586 (#3588)

#### Added
* feature: adding set contract status command #3583 (#3596)
* feature: defining signed_at date for contract party when re uploading a signed contract #3585 (#3595)
* feature: adding a selector for enterprise owner of a contract #3582 (#3591)

#### Changed
* chore: replace old link to new contract system entry #3569 (#3592)

### [0.70.3]
#### Changed
* feature: reworking layout show contract #3525 (#3571)
* fix: removing unsused parameter (#3578)

### [0.70.2]
#### Added
* feature: create contract without model (#3568)
* feature: add factoring to inbound invoices #3528 (#3560)
* feature: send email to contract party that needs to add documents #3530 (#3566)
* feature: adding system variables when creating contract model variables #issue-3528 (#3564)
* feature: upload signed contract #3531 (#3559)
* feature: allowing to create amendment contracts #3441 (#3557)
* feature: adding direct assignment for an offer #issue-3534 (#3558)
* feature: create contract part #3533 (#3551)

#### Changed
* feature: sort lines by creation date #3561 (#3565)
* feature: display the siret and the legal form of the enterprise #3539 (#3549)
* feature: allowing only support and contract owner to edit variable values #3529 (#3552)

### [0.70.1]
#### Added
* feature: Add the unit Unit in the dropdown list #issue-3547 (#3554)
* fix: deleting old contract parts when generating a contract #issue-3526 (#3544)

#### Changed
* feature: giving ability to support to edit document dates on the fly #3535 (#3545)
* feature: modify the wording of the siret number filter in sogetrel passwork index #issue-3546 (#3550)

#### Fixed
* fix: repairing the reactivated button once the user has been deactivated (#3553)
* fix: adjust the back button and the breadcrumb #issue-3527 (#3541)
* refactor: fix bugs and improvments in contract model #3517 (#3520)
* fix: null date error in document show #3535 (#3555)

### [0.70.0]
#### Changed
* chore: add sending vendor to navibat scheduler (#3521)
* fix: adding job to generate outbound invoice file (#3522)

#### Fixed
* fix: create invoice parameter test (#3524)
* fix: file translation components (#3523)

### [0.69.6]
#### Added
* feature: adding contract parts to show contract (#3518)

### [0.69.5]
#### Added
* feature: generate contract #3485 (#3514)

### [0.69.4]
#### Added
* feature: improvments in contracts #3482 (#3515)
* feature: giving ability to upload many documents on mission tracking  #3469 (#3512)

#### Changed
* chore: changelogs for v0.69.4
* fix: getting jobs and skills from all the ancestors when creating an offer #issue-3477 (#3513)
* (tech) infrastructure: removing risky (unused) tests (#3358)

### [0.69.3]
#### Added
* feature: check if contract is ready to generate #3484
* feature: creating contract variable index (#3505)
* feature: filing documents for the contract #issue-3483 (#3506)
* feature: send project of contract to parties #3481 (#3498)
* (tech) infrastructure: add liuggio/fastest package (#3503)
* feature: listing contract parties on contract show #3486 (#3502)
* feature: Complete variables #3444 (#3473)
* feature: adding information about variables on the add contract part view and fixing wysiwyg text #3487 (#3500)
* feature: adding show contract #3480 (#3493)
* feature: editing contract model variables #issue-3488 (#3492)

#### Fixed
* feature: fixing contract model views translations #3446 (#3507)

#### Changed
* chore: changelogs for v0.69.3

### [0.69.2]
#### Added

* feature: deleting a contract #issue-3440 (#3490)
* feature: display amounts when activate filter in inbound invoice show #3476 (#3497)

#### Changed
* feature: change policy of inbound invoice show #3474 (#3496)

### [0.69.1]

#### Fixed
* fix: signatory relation in contract party model old system (#3494)

### [0.69.0]
#### Added

* feature: updating changelog for v0.69.0

### [0.68.3]
#### Added

* feature: identifying contract parties #issue-3442 (#3472)

### [0.68.2]
#### Fixed

* fix: reverting some changes in file model to fix file upload (#3471)
* fix: lots of fixes
* (tech) fix: psr-2
* (tech) fix: missing method

#### Changed

* feature: updating access and onboarding of guest member #3466 (#3470)
* chore: adapting contract tables to contract v2 (#3458)

#### Added

* feature: editing contract #3439 (#3459)
* feature: adding contract index for support (#3468)
* feature: create invoice parameters #3448 (#3463)
* app_translation_AC_DE_2020-11-25-2 (#3464)
* feature: adding contract index #3423 (#3461)
* feature: app translation ac de 2020 11 24 (#3462)
* (tech) fix: ci.sh to exclude js files
* feature: new service for document validation
* feature: adding urssaf document validator
* feature: implementing kbis validation library
* feature: adding infogreffe scrapper
* feature: extracting data from urssaf certificates
* feature: base implementation for document extractor interfaces
* feature: interfaces for docs detectors and extractors
* feature: adding job
* chore: testing the create full text use-case
* chore: registering new providers
* feature: all formats are now accepted by create full text
* chore: adding migration
* (tech) feature: more file methods!
* chore: changes in google vision api tests
* feature: text extractor
* feature: adding the full-text representation of a pdf file
* (tech) chore: adding bdelespierre/blade-linter back
* feature: creating contract from a contract model #issue-3438 (#3460)
* feature: adding inbound invoices index for customer #3433 (#3450)
* app_translation_DE_2020-10-27 (#3454)
* feature: add changelog for v0.68.01 release (#3456)

### [0.68.1] 2020-11-23
#### Fixed
* fix: type filters on enterprise index for support (#3451)
* feature: fix preview pdf of contract model #3435 (#3452)

#### Changed
* feature: updating activity report requesting notification dates #issue-3437 (#3455)
* feature: edit non compliance email #3394 (#3421)

#### Added
* feature: listing contract model variables #issue-3399 (#3430)

### [0.68.0]
#### Fixed
* fix: send vendors document to sogetrel ftp (#3453)
* fix: translations babel file (#3449)

### [0.67.3] 2020-11-17
#### Fixed
* fix: use ghostscript to merge and compress pdfs before send to navibat (#3429)
* fix: filters persistence and adding number items selector to inbound invoices index (#3428)
* fix: filters persistence and adding number items selector (#3427)

#### Added
* feature: sogetrel mission tracking line enhancements #3420 (#3425)
* feature: creating contract model preview #3400 (#3418)
* feature: change display of dates in document show view #3397 (#3419)

#### Changed
* chore: bump addworking/foundation to v2.1

### [0.67.2] 2020-11-12
#### Added
* feature: publishing a contract model #issue-3314 (#3416)
* feature: making login email case insensitive #issue-3396 (#3417)
* feature: delete a contract model piece #3401 (#3409)

#### Changed
* infrastructure: upgrade laravel framework to v8 #3320 (#3415)

### [0.67.1] 2020-11-06
#### Fixed
* fix: combine pdf files and change name when send it in ftp sogetrel (#3410)
* fix: filter persistence and view 1OO contracts per page #3395 (#3411)

#### Added
* feature: adding new enterprise index for support #3393-2 (#3414)
* feature: updating the model contract part #issue-3402 (#3408)
* feature: listing contract model parts #3403  (#3407)
* chore: translations (#3404)
* chore: translations (#3379)
* chore: translations (#3377)

#### Changed
* chore(deps): bump dot-prop from 4.2.0 to 4.2.1 (#3413)
* chore(deps): bump bl from 1.2.2 to 1.2.3 (#3412)

### [0.67.0] 2020-11-04
#### Fixed
* fix: requesting activity reports in the beginning of the month too #issue-3398 (#3405)

### [0.66.7] 2020-10-30
#### Fixed
* fix: vendor dashboard and mission tracking line store (#3390)

### [0.66.6] 2020-10-30
#### Fixed
* fix: mission tracking line create (#3389)

#### Added
* feature: deleting document-type that was previously asked on a contract model for a contract model party (#3384)
* feature: adding job on passwork sogetrel #3354 (#3373)
* feature: adding a part to contract model (#3382)
* feature: index document type of contract model party #3366 (#3385)
* feature: adding production condition for domain route helper method #3355 (#3386)
* feature: adding comment to vendor interrested for bpu email #3353 (#3383)
* feature: adding translation to status filter of outbound index #3352 (#3381)
* feature: creating feature that allows to create a document type for contract model #3364 (#3374)
* feature: deleting contract model party #issue-3363 (#3372)

### [0.66.5] 2020-10-27
#### Fixed
* fix: add actual month in list when create inbound invoice (#3380)

#### Added
* infrastructure: adding heroku buildpack poppler (#3378)

### [0.66.4] 2020-10-25
#### Fixed
* fix: modify filter of vendors to notify in activity report command #3357 (#3375)

#### Added
* feature: sort inbound invoices export by vendor name #3317 (#3376)
* feature: adding contract model parties #issue-3362 (#3370)

### [0.66.3] 2020-10-21
#### Fixed
* fix: show document in index (#3371)

### [0.66.2] 2020-10-20
#### Fixed
* fix: remove dupplication of main activity code form (#3369)

### [0.66.1] 2020-10-20
#### Added
* feature: edit main activity code by support #3351 (#3365)
* feature: adding show view for contract model #issue-3356 (#3359)

#### Changed
* chore: update sentry config (#3368)

### [0.66.0] 2020-10-19
#### Added
* feature: add list contract models by support usecase #3227 (#3346)
* feature: deleting drafted contract model #issue-3228 (#3344)

### [0.65.4] 2020-10-15
#### Fixed
* fix: change id by name in filter contract by vendor index action (#3347)

### [0.65.3] 2020-10-15
#### Added
* feature: eager loading index contract (#3342)
* feature: updating drafted contract model #issue-3226 (#3341)
* feature: google vision api tests (#3340)
* infrastructure: adding more translation commands (#3339)
* feature: setting up the contract model component : creating empty contract model #issue-3225 (#3325)
* feature: adding confirm box for purchase order generation #3319 (#3335)

### [0.65.2] 2020-10-12
#### Fixed
* fix: implementing feedbacks for mtla #3330 (#3333)
* fix: document policy for onboarding #3331 (#3332)

### [0.65.1] 2020-10-08
#### Fixed
* fix: index contract filter #3262 (#3311)

#### Added
* feature: clarifying why vendor can't upload his invoices #3321 (#3327)
* feature: contract v2: adding migrations for templates (#3329)
* feature: change scheduler for non-compliance command #3318 (#3328)
* feature: adding link to mission of the offer #3316 (#3326)
* feature: mission tracking line attachment show page #3324
* feature: mission tracking line attachment file #3323

### [0.65.0] 2020-10-05
#### Fixed
* fix: restricting access to other enterprise resources #issue-3269 (#3300)
* fix: displaying icon of onboarding status on vendor index #3271 (#3305)

#### Added
* feature: sending csv export of last month activity reports to support #issue-3288 (#3290)
* feature: add optical network maintenance to passwork search (#3308)

### [0.64.5] 2020-10-02
#### Fixed
* fix: includes interfaces an traits and rename classes properly (#3306)
* fix: profile route (#3307)

#### Added
* chore: translations (#3304)

### [0.64.4] 2020-09-30
#### Added
* feature: add translation key to menu views and french translation
* feature: adding filters on mission tracking line support index #3302
* feature: adding wording to invitation index #3231 (#3299)
* chore: translations (#3298)
* feature: mission tracking line support index #3203
* feature: fix duplication when sending new proposal #3270 (#3295)
* feature: adding change locale dropdown (#3292)
* chore: updating translations
* feature: mission tracking line attachment create
* feature: applying component interfaces on models
* feature: adding mission tracking and tracking line use-cases
* infrastructure: adding user interfaces
* infrastructure: adding entreprise interfaces
* infrastructure: adding common interfaces
* chore: translations (#3296)

#### Changed
* feature: updating mission breadcrumb partials

#### Removed
* feature: remove onboarding check to non-compliance command #3272 (#3297)

### [0.64.3] 2020-09-29
* infrastructure: add temporary url attribute to file model (#3294)

### [0.64.2] 2020-09-29
#### Added
* infrastructure: insall scout apm monitor (#3289)
* feature: refactoring of mission proposal show (#3287)
* chore: translations (#3293)

### [0.64.1] 2020-09-28
#### Fixed
* fix: actions menu of passwork #3264 (#3281)

#### Added
* feature: getting current month work history for sogetrel vendors #issue-3223 (#3241)
* feature: refactoring proposal response tab on offer show #3265 (#3282)
* chore: translation (#3286)
* chore: translations (#3285)
* chore: translations (#3284)
* chore: translations (#3280)
* chore: translations (#3283)

### [0.64.0] 2020-09-23
#### Fixed
* fix: megatron #3276 #3273

#### Added
* feature: create enterprises csv export #3246-1 (#3255)
* feature: add questions in sogetrel passwork #3268 (#3279)
* chore: translations (#3278)
* chore: translations (#3277)
* chore: translations (#3260)
* chore: translations (#3259)

#### Changed
* chore: bump addworking/foundation to v1.6

### [0.63.10] 2020-09-21
* fix: wording non compliance notification for vendors (#3261)

### [0.63.9] 2020-09-18
#### Fixed
* fix: change visibility of author and created_at of comments (#3257)
* fix: create credit fees test (#3258)
* fix: onboarding passwork validation route generation #3247 (#3248)

### [0.63.8] 2020-09-16
#### Fixed
* fix: notifications of Exipry and outdated documents (#3256)

#### Added
* chore: translations (#3254)
* chore: translations (#3252)

### [0.63.7] 2020-09-15
#### Added
* feature: edit rules of non-compliance notification #3222 (#3238)

### [0.63.6] 2020-09-15
#### Fixed
* fix: outdated documents command (#3253)

### [0.63.5] 2020-09-14
#### Fixed
* fix: adding customers ancestors to document expired checking (#3251)

### [0.63.4] 2020-09-14
#### Fixed
* fix: fix expired documents command (#3250)

### [0.63.3] 2020-09-14
#### Fixed
* fix: fix update documents to outdated status (#3249)

#### Added
* feature: sogetrel mission tracking line attachment migration & models (base) #3202 (#3245)

### [0.63.2] 2020-09-10
#### Added
* feature: improvment of fees csv builder (#3244)
* feature: adding csv export for fees (#3243)
* chore: translations (#3237)

### [0.63.1] 2020-09-08
#### Fixed
* fix: proposal show route #issue-3239 (#3240)

### [0.63.0] 2020-09-07
#### Added
* chore: translations (#3212)
* feature: make received payment as multiple (#3234)
* feature: change wording for expired docs notifications #3230 (#3233)
* feature: adding alert for expired docs #3219 (#3221)
* feature: revamped megatron command (#3220)
* feature: making vendor active by default when referencing it with a client #issue-3217 (#3218)
* feature: updating rules for notify vendor of his outdated documents #3193 (#3210)

#### Changed
* chore(deps): bump http-proxy from 1.17.0 to 1.18.1 (#3235)
* chore(deps): bump decompress from 4.2.0 to 4.2.1 (#3216)

### [0.62.8] 2020-09-03
#### Fixed
* fix: calculate commissions button in index fee (#3214)

#### Added
* feature: checking subdomain when sending notifications #issue-2997 (#3211)
* feature: excluding inactive vendors from conformity check #issue-3143 (#3151)

### [0.62.7] 2020-09-02
#### Fixed
* fix: column cps3 active on vendor export #3162 (#3189)

#### Added
* feature: create addworking fees usecase #3195 (#3199)
* feature: counting accepted vendor invitations #issue-3157 (#3173)
* feature: adding label for iban #3197 (#3198)

### Changed
* feature: change reference of payment order #3196 (#3199)

### [0.62.6] 2020-09-01
#### Fixed
* fix: attach phone number unique #3160 (#3191)

### [0.62.5] 2020-09-01
#### Fixed
* fix: select periods in inbound invoice form (#3190)

### [0.62.4] 2020-08-31
#### Fixed
* fix: force date format for mission proposal #3181 (#3188)

#### Added
* feature: edit received payment #3176 (#3186)

### [0.62.3] 2020-08-31
#### Added
* feature: list received payment for an outbound invoice #3176 (#3185)

#### Changed
* chore: move payment order from billing/outbound to billing/payment_order #3177 (#3187)

### [0.62.2] 2020-08-28
#### Fixed
* fix: include current month in select periods of outbound invoice (#3184)

#### Added
* feature: create received payment for outbound invoice #3175 (#3179)
* feature: make optionnal ends date of activity period for a resource #3163 (#3172)

#### Changed
* chore: improvments in outbound component (#3178)

### [0.62.1] 2020-08-26
#### Added
* feature: adding edit action for phone number of user #3165 (#3170)

#### Changed
* chore: improvements in outbound component (#3171)

### [0.62.0] 2020-08-25
#### Fixed
* fix: link between vendor index and contracts #3037 (#3133)

#### Added
* feature: mark payment order as paid #3031 (#3169)
* feature: adding destroy action for payment_order #3030 (#3167)
* feature: adding enterprise of user in show view #3164 (#3168)
* feature: generate payment order file #3029 (#3154)

### [0.61.1] 2020-08-17
#### Fixed
* fix: send invoice paid notification to vendors (#3155)
* fix: typos (#3142)
* fix: typos (#3141)
* fix: translation files
* fix: excluding deleted files from pre-commit analysis
* fix: typos (#3140)
* fix: error translation labels
* fix: translations
* fix: adding confirmation to translation:add-missin-key command
* fix: contract party status display #3036 (#3131)
* fix: namespace issues

#### Added
* feature: adding contact name && contact enterprise name to the vendor invitation #issue-3132 (#3150)
* feature: dissociate inbound invoice from payment order #3028 (#3145)
* feature: add activity date to relation between customer and vendor (#3146)
* feature: associate inbound invoice to payment order #3027 (#3138)
* chore: adding translation:check to bin/pre-commit.sh and bin/ci.sh
* chore: adding blade:lint to bin/pre-commit.sh and bin/ci.sh
* feature: better serialization in translation:fix command
* feature: adding translation:fix command
* chore: translations (#3139)

#### Changed
* chore: bumping bdelespierre/laravel-blade-lint to v1.1.0

#### Removed
* chore: removing consistency tests
* chore: removing joedixon/laravel-translation package

### [0.61.0] 2020-08-17
#### Added
* feature: adding outbound invoice link on inbound invoice informations (#3135)
* chore: translations (#3129)
* feature: adding translation:add-missing-keys command

### [0.60.14] 2020-08-14
#### Fixed
* fix: payment ordres views (#3128)
* fix: pre-commit hook now validates all cached files
* fix: excluding acceptance test from phpcs analysis
* fix: missing relation in payment order factory

#### Added
* chore: translations (#3118)
* feature: adding show view for payment order #3119 (#3120)
* feature: edit payment order (#3122)
* feature: adding division of skills index #3061 (#3125)
* feature: adding joedixon/laravel-translation package
* feature: new translation:summary command
* feature: adding class:rename command

### [0.60.13] 2020-08-12
#### Fixed
* fix: outbound invoice link on customer dashboard

### [0.60.12] 2020-08-12
#### Fixed
* fix: export of outbound invoice items (#3124)

### [0.60.11] 2020-08-11
#### Fixed
* fix: enabling contract parties in contract action menu #3109

#### Added
* feature: add export of outbound invoice items and customers vieuw of outbound invoice (#3123)
* chore: translations (#3121)
* feature: adding index to payment orders #3114 (#3116)

### [0.60.10] 2020-08-10
#### Fixed
* fix: removing deadline from outbound invoice labels

### [0.60.9] 2020-08-10
#### Fixed
* fix: inbound invoice show view (#3117)

#### Added
* chore: adding a script that aggregates git commits
* feature: better translation commands

### [0.60.8] 2020-08-10
#### Fixed
* fix: ci step numbers
* fix: ci scripts

#### Added
* feature: add number phone in registration form and logs in sync to storage command #3062 (#3112)
* feature: making the pre-commit hook more efficient
* feature: payment order uc-1 (#3105)
* feature: missing key in translation checker

### [0.60.7] 2020-08-05
#### Fixed
* fix: email translations and export vendors (#3111)

### [0.60.6] 2020-08-05
#### Fixed
* fix: sogetrel navibat ftp command

#### Added
* chore: translations (#3106)
* chore: translations (#3107)
* chore: translations (#3110)
* chore: translation (#3108)

### [0.60.5] 2020-08-03
#### Fixed
* fix: purchase prder translation (#3102)

### [0.60.4] 2020-07-31
#### Fixed 
* fix: views syntax errors
* fix: outbound invoice label display

#### Changed
* feature: edit wording for passwork sogetrel question (#3093)
* feature: refactoring display items and button on invitation's views (#3092)

#### Added
* feature: add enterprise filter on contract.index #3098 (#3099)
* feature: display all enterprises in addworking contract forms (#3097)
* feature: updating contract counters #3100
* featire: contract addendums (#3088)
* feature: adding the helpdesk link to the navbar (#3095)
* chore: translations (#3094)
* chore: adding magentron/laravel-blade-lint
* feature: check if vendor is active before notify him for his documents (#3084)
* chore: adding translation for folder and invitation (#3086)
* chore: translations (#3091)
* chore: bump elliptic from 6.5.2 to 6.5.3 (#3090)
* chore: translations (#3087)
* chore: translations (#3085)

### [0.60.3] 2020-07-28
#### Fixed
* fix: onboarding process steps translations

#### Added
* feature: adding multiple relaunch for invitations (#3083)
* chore: translations (#3079)

### [0.60.2] 2020-07-28
#### Added
* feature: add status to outbound invoice (#3082)
* feature: create tables of payment order system (#3080)
* feature: edit outbouns invoice uc-12 #issue-2970 (#3074)
* feature: automatic cps2 creation from vendor (#3054)
* feature: adding destroy action for credit addworking fees (#3069)

#### Changed
* feature: refactoring acceptation modal for sogetrel (#3081)
* chore: bumping addworking/foundation to v1.5.0

### [0.60.1] 2020-07-28
#### Fixed
* fix: register controller with captcha
* fix: typo in outbound_invoice/edit.blade.php

### [0.60.0] 2020-07-27
#### Fixed
* fix: typo in translation file
* fix: blade typos

#### Added
* feature: hide non-contractual documents from vendor document list (#3071)
* chore: translations (#3043)
* chore: translations (#3050)
* feature: adding the trans:check command (#3070)
* feature: register recaptcha (#3048)
* feature: adding destroy action for ad-hoc line on outbound invoice (#3052)
* feature: billing uc-10 part-3 (#3018)
* chore: translations (#3055)
* feature: Migrating files to s3 #issue-2931 (#2951)

### [0.59.10] 2020-07-23
#### Added
* feature: listing active customer assigned resources #issue-3004 (#3047)

### [0.59.9] 2020-07-23
#### Added
* fix: translation inbound invoice (#3051)

### [0.59.8] 2020-07-22
#### Added
* feature: adding attachments to resources #issue-3045 (#3046)
* chore: billing translations (#3044)

### [0.59.7] 2020-07-22
#### Added
* feature: create activity period on entrprise resources #3005 (#3042)
* feature: adding resource component (crud) (#3033)
* feature: adding new translation keys (#3020)
* chore: updating translations (#3040)

#### Changed
* feature: refactoring show document view (#3041)

### [0.59.6] 2020-07-20
#### Added
* feature: add select customer addresses when generate file of outbound invoice (#3034)
* feature: preventing customers & vendors from updating some information about their enterprise #issue-2999 (#3024)

### [0.59.5] 2020-07-17
#### Fixed
* fix: removing inconsistent test

### [0.59.4] 2020-07-17
#### Fixed
* fix: login without password

#### Added
* feature: contract v2 (#2862)
* feature: billing uc-10 part-2 (#2995)

### [0.59.3] 2020-07-17
#### Fixed
* fix: queueing notifications when sharing sogetrel passworks (#3021)
* chore: bump lodash from 4.17.15 to 4.17.19 (#3019)

### [0.59.2] 2020-07-15
* fix: delete line of total management fees in outbound invoice file (#3017)
* feature: billing uc-16 (#3010)
* feature: sharing passwork to multiple recipients #issue-2998 (#3012)

### [0.59.1] 2020-07-15
* fix: remove legal notice from outbound invoice create (#3011)

### [0.59.0] 2020-07-13
#### Fixed
* fix: multiple bug in generate file and add discount of fees (#3008)

#### Added
* feature: displaying the enterprise logo in the show view #issue-2958 (#2992)

#### Removed
* fearure: removing support notification about document creation #issue-xxx (#2993)

### [0.58.7] 2020-07-10
#### Added
* feature: add options before generate file of outbound invoice (#2991)
* feature: billing uc-10 (#2987)

### [0.58.6] 2020-07-09
#### Added
* feature: add extrenal_id to mission tracking and fix multiple bug in outbound invoice system (#2990)

### [0.58.5] 2020-07-07
#### Fixed
* fix: auto-generation of outbound invoice in old system (#2986)

### [0.58.4] 2020-07-06
#### Fixed
* fix: addding contract dispatcher

#### Added
* feature: create show view of outbound invoices uc-13 #issue-2971 (#2985)
* feature: billing uc-11 (#2982)

### [0.58.3] 2020-07-03
#### Fixed
* fix: constraining images display in iframes #2966 (#2967)

#### Added
* feature: billing system v2 part-2 #2597 (#2946)

### [0.58.2] 2020-07-02
#### Fixed
* fix: edit view of inbound invoice (#2968)

### [0.58.1] 2020-07-02
#### Fixed
* fix: inbound invoice show view (#2965)

### [0.58.0] 2020-07-01
#### Fixed
* fix: old system of outbound invoices (#2960)
* fix: search by name in sogetrel passwork index form #2956

#### Added
* feature: exclude informative & optional documents types from both noncompliance notification & vendor csv export #issue-2927 (#2948)
* feature: new repository manager (#2952)

### [0.57.5] 2020-06-24
#### Fixed
* fix: exclude onboarding vendors from noncompliance notifications #issue-2914 (#2924)

#### Added
* feature: adding new columns in the vendor csv export #issue-2932 (#2941)
* feature: removing prefilling accepted passwork modal in sogetrel passwork show view #issue-2939 (#2945)
* feature: billing system v2 part-1 (#2773)

### [0.57.4] 2020-06-19
#### Fixed
* fix: index views without  #2930

### [0.57.3] 2020-06-18
#### Fixed
* fix: fix forelse of inbound invoice item index (#2928)

### [0.57.2] 2020-06-17
#### Added
* feature: vendors referents #boyscout #issue-2882 (#2908)

#### Fixed
* fix: vendor management test
* fix: foundation package configuration

#### Changed
* chore: bumping addworking/foundation to v1.1.4

#### Removed
* chore: removing unused github templates

#### Security
* chore: bump websocket-extensions from 0.1.3 to 0.1.4 (#2909)

### [0.57.1] 2020-06-05
#### Added
* feature: handling subdomain in generated routes when sending emails #issue-2836 (#2860)
* feature: add history of vendor documents #2890 (#2892)
* feature: adding tooltip for display comments on documents index #2884 (#2891)

#### Changed
* feature: updating index inbound invoice item behavior #2760 (#2889)

### [0.57.0] 2020-06-01
#### Added
* feature: adding logo for customers #issue-2874 (#2877)
* feature: adding documents reasons for rejection #2883 (#2887)

#### Changed
* feature: updating columns of onboarding csv #2885 (#2888)

### [0.56.5] 2020-05-28
#### Added
* feature: adding search anscetors to customer filter in support document index #2832 (#2878)

#### Changed
* feature: updating vendor csv (#2875)

### [0.56.4] 2020-05-28
#### Fixed
* fix: updating user current enterprise with multiple enterprises when detaching him from his current enterprise #issue-2879 (#2880)

### [0.56.3] 2020-05-27
#### Changed
* chore: update composer.lock (#2876)

### [0.56.2] 2020-05-26
#### Fixed
* fix: error when associate tracking lines to inbound invoice #2761 (#2871)
* fix: minimum file size when storing passwork with file #issue-2868 (#2869)

#### Added
* feature: update columns of vendor csv #issue-2831 (#2843)
* feature: adding replace document action in action menu of documents #2838 (#2866)
* feature: adding analytic code for everial referential mission #2839 (#2865)
* feature: fixing wording on sogetrel passwork #issue-2840 (#2864)
* feature: adding mission number to the title of mission tracking #2842 (#2863)
* feature: ordering by name in vendors indew view #issue-2841 (#2859)
* feature: adding notification choice for support on mission tracking creation #issue-2826 (#2829)
* feature: notifying support when a vendor is detached #issue-2835 (#2856)
* feature: adding search by identification_number in sogetrel passwork index view #issue-2804 (#2854)

### [0.56.1] 2020-05-20
#### Fixed
* fix: fixing uploaded file size to 1ko for the entire app #issue-2587 (#2846)

### [0.56.0] 2020-05-18
#### Fixed
* fix: hiding orphan documents #issue-2830 (#2844)

### [0.55.4] 2020-05-14
#### Added
* feature: adding link to reconciliation in inbound view show state info #issue-2827 (#2828)

### [0.55.3] 2020-05-14
#### Added
* feature: helping customer to see if he needs reconciliation #issue-2811 (#2816)
* feature: updating vendor csv #issue-2806 (#2813)

### [0.55.2] 2020-05-13
#### Fixed
* fix: purchase order layout (#2825)

### [0.55.1] 2020-05-12
#### Fixed
* fix: updating tracking attachable file #issue-2805 (#2821)
* fix: fixing inbound invoices index display #issue-2817 (#2822)

#### Added
* feature: adding invite member action to member index and wording #issue-2808 (#2818)
* feature: adding destroy mission tracking line for support #issue-2759 (#2810)
* feature: permitting client to see its vendor phone numbers #issue-2807 (#2812)

### [0.55.0] 2020-05-05
#### Fixed
* fix: error in support tracking line index (#2802)
* fix: removing thousand separator #issue-2762 (#2799)

#### Added
* feature: adding a label field for the first created tracking line #issue-2757
* feature: normalizing edenred offer process #issue-2596 (#2797)

### [0.54.3] 2020-04-30
#### Fixed
* fix: contract index view

#### Added
* feature: listing customer folders for vendors #addw-2779 (#2795)
* feature: adding phpstats.sh
* feature: adding new document type for customers #addw-2777 (#2781)

### [0.54.2] 2020-04-28
#### Fixed
* fix: inbound invoice item index error #issue-2783 #issue-2790 (#2791)
* fix: contract v2 migration
* fix: use  instead of (#2776)

#### Added
* feature: permitting a negative quantity when creating a tracking line #issue-2763 (#2787)
* feature: adding total HT column in mission tracking show view #issue-2758 (#2786)
* chore: bumping addworking/contract to v1.2.1
* chore: migrations for contract v2 #2696 (#2774)
* feature: adding confirm box for delete action #issue-2756 (#2775)
* feature: searching by vendor name in outbound invoice index view #issue-2765 (#2772)
* feature: adding mission number to inbound_item create_from_mission_tracking_lines view #issue-2755 (#2770)
* feature: adding notification request for close offer #2595 (#2752)

### [0.54.1] 2020-04-22
#### Fixed
* fix: contract views & policies
* fix: viewable trait for models #2750

#### Added
* feature: adding navibat_id to searchable elements for enterprise #boyscout #issue-2767 (#2769)

#### Changed
* infrastructure: moving code to addworking/contract #2750
* infrastructure: relocating code to addworking/foundation #2753

### [0.54.0] 2020-04-20
#### Fixed
* fix: putting back addworking logo in mail template #issue-2590 (#2748)

#### Changed
* chore: destroying the contract system #2695
* chore: migrating methods from contracts to repositories #2715 (#2718)

### [0.53.6] 2020-04-15
#### Fixed
* fix: user read_messages table #issue-2591 (#2717)
* fix: handling uniqueness of address #issue-2588 (#2716)
* fix: correction redirection on outbound invoice number #addw-2592 (#2714)

#### Added
* feature: adding searchable trait on documents index #addw-2606 (#2632)
* feature: adding searchable trait on mission tracking line index #addw-2609 (#2633)

### [0.53.5] 2020-04-10
#### Fixed
* fix: change location of comments in inbound invoice show (#2637)

#### Added
* feature: enabling searchable for folder index view #boyscout #issue-2608 (#2636)
* feature: enabling searchable for outbound index view #issue-2602 (#2631)

### [0.53.4] 2020-04-09
#### Fixed
* fix: change database type of quantity inbound invoice item to float (#2635)

### [0.53.3] 2020-04-09
#### Fixed
* fix: avoiding duplicate objects in searchscope test for enterprise (#2622)

#### Added
* feature: adding searchable feature to inbound invoice index #addw-2601 (#2618)
* feature: enabling searchable for contract index view #boyscout #issue-2607 (#2624)
* feature: enabling searchable for mission referential index view #issue-2610 (#2623)
* feature: enabling searchable for edenred code index view #issue-2605 (#2621)

### [0.53.2] 2020-04-07
#### Added
* feature: add 2 new vendors to tse config file (#2620)

### [0.53.1] 2020-04-07
#### Fixed
* fix: change date format in mission csv loader for tse (#2619)

#### Added
* feature: enabling searchable for jobs/skills in vendors view #2600 (#2617)

### [0.53.0] 2020-04-06
#### Fixed
* fix: mission location attribute (#2615)
* fix: handling request validation prequalified button action in sogetrel passwork #2589 (#2613)

#### Added
* feature: enabling searchable for onboarding process index view #boyscout #addw-1315 (#2585)
* feature: enabling searchable for purchase order index view #addw-1311 (#2584)
* feature: enabling searchable for user index view #boyscout #addw-1316 (#2582)

### [0.52.7] 2020-04-02
#### Fixed
* fix: soprema covid19 show #addw-1346 (#2579)

#### Added
* feature: enabling searchable for proposal index view #addw-1312 (#2580)
* feature: enabling searchable for offer index view #boyscout #addw-1336 (#2578)

#### Changed
* chore: upgrading to laravel 7

### [0.52.6] 2020-03-31
#### Fixed
* fix: billing deadline parameters for vendors #addw-1345 (#2577)

#### Added
* feature: enabling searchable for enterprise index view #boyscout #addw-1319 (#2566)

### [0.52.5] 2020-03-31
#### Changed
* feature: refactoring inbound invoice system #epic #addw-1206 (#2549)

### [0.52.4] 2020-03-30
#### Fixed
* fix: removing soprema wording from covid19 forms

#### Added
* feature: more filters & glitters on covid19 form answers
* feature: adding searchable trait to mission index #addw-1310 (#2575)

### [0.52.3] 2020-03-27
#### Fixed
* fix: soprema covid19 form

### [0.52.2] 2020-03-27
#### Added
* feature: soprema covid19 form

### [0.52.1] 2020-03-26
#### Added
* feature: linking templates to contracts #addw-1278 (#2539)
* feature: listing jobs/skill of the customer and his ancestors #addw-1333 (#2564)
* feature: adding customer reference on mail for vendor non compliance #addw-1335 (#2558)

#### Fixed
* fix: better validation in item update #addw-1285 (#2565)
* fix: contract create form #addw-1286 (#2567)
* fix: send navibat #addw-1288 (#2568)
* fix: unsortable column #addw-1294 (#2570)
* fix: index offer answers policiy #addw-1297 (#2571)
* fix: adding maxlength to enterprise activity form-control #addw-1299 (#2572)
* fix: prevent file path collision in inbound invoice #addw-1327 (#2573)
* fix: adding validation on sogetrel passwork status update #addw-1328 (#2574)
* fix: date validation in document store #addw-1298 (#2563)
* fix: invalid vendor link #addw-1291 (#2569)
* fix: document to s3 sync (#2559)

### [0.52.0] 2020-03-23
#### Added
* feature: adding comments to inbound invoice #addw-1276 (#2547)
* feature: adding anchor on url #addw-1283 (#2555)

### [0.51.10] 2020-03-19
#### Fixed
* fix: starts_at filter for mission index view #boyscout #addw-1301 (#2554)
* fix: handling passwork sharing action when the user did not request a copy #addw-1251 (#2550)

### [0.51.9] 2020-03-18
#### Fixed
* fix: document to s3 zip

### [0.51.8] 2020-03-18
#### Fixed
* fix: handling siret uniqueness when updating enterprises #addw-1271 (#2546)

#### Added
* feature: adding links to offer view proposals tab for sogetrel #addw-1280 (#2520)

### [0.51.7] 2020-03-18
#### Fixed
* chore: npm audit fix

#### Added
* feature: adding covid alert for customers and vendors #addw-1304 (#2548)
* chore: how to refactor models
* chore: adding branch butchering tutorial
* feature: adding bin/find-usage.sh
* feature: adding crud for contract template #addw-1277 (#2536)
* feature: enabling searchable for client vendors view #addw-1169 (#2514)

#### Changed
* chore: moving code from enterprise into repositories
* chore(deps): bump acorn from 6.3.0 to 6.4.1 (#2537)
* chore: updating pull-request template

### [0.51.6] 2020-03-13
#### Fixed
* fix: indentation issue

### [0.51.5] 2020-03-13
#### Fixed
* fix: fixing minimum uploaded file size for iban to 1ko #addw-1274 (#2531)

#### Added
* feature: adding dry-run mode to compliance check command

#### Changed
* chore: updating pull request template

#### Removed
* chore: removing old dumps

### [0.51.4] 2020-03-12
#### Fixed
* fix: passwork policies #addw-1292 (#2519)
* fix: expiring condition and handling #addw-1289 (#2517)

### [0.51.3] 2020-03-10
#### Fixed
* fix: ci break

### [0.51.2] 2020-03-10
#### Fixed
* fix: action component

#### Changed
* chore: moving addworking methods in repos (#2515)

### [0.51.1] 2020-03-10
#### Fixed
* reported errors in the invitation system #addw-1275 (#2512)
* (tech) various fixes

#### Added
* folders

#### Changed
* chore: refactor datalayer for better updates (#2513)

### [0.51.0] 2020-03-09
#### Fixed
* fix: validating uuids before querying #addw-1270 (#2507)
* fix: correct gtm head (#2509)

#### Added
* feature: send email to compliance managers #addw-1253 (#2505)

### [0.50.7] 2020-03-05
* chore: improve datalayer (#2504)

#### Changed
* feature: better handling enterprise switch #boyscout #addw-1255 (#2500)

### [0.50.6] 2020-03-02
#### Added
* feature: Invite vendor when create a mission offer (#2492)
* chore: add google tag manager account (#2503)

### [0.50.5] 2020-02-27
#### Added
* feature: adding csv export to tracking lines #addw-1234 (#2501)
* feature: adding document type type filter on support document index #addw-1264 (#2497)

#### Changed
* feature: reverting back legal & business confirmity columns in client vendors view #addw-1247 (#2498)

#### Fixed
* fix: sogetrel data tab in enterprise show view (#2502)

### [0.50.4] 2020-02-24
#### Fixed
* fix: create offer in edenred domain #addw-1268 (#2499)

#### Added
* feature: adding electrical_car_charging capability in sogetrel passwork #addw-1257 (#2490)
* feature: adding taxes number of addworking on inbound create #addw-1258 (#2496)
* feature: adding mission number on tracking index #addw-1256 (#2494)

#### Changed
* feature: filtering shown data in enterprise show view #boyscout #addw-1215 (#2481)
* feature: handling label filter for offers index #addw-1263 (#2495)

### [0.50.3] 2020-02-26
#### Fixed
* fix: command sending vendors documents to navibat (#2493)

#### Changed
* feature: sending the accept-offer mail if the offer is closed via checkbox #addw-1259 (#2489)

### [0.50.2] 2020-02-25
#### Fixed
* fix: inbound invoice month change
* fix: old vendor management page

### [0.50.1] 2020-02-25
#### Fixed
* fix: outbound validation view (#2488)

### [0.50.0] 2020-02-24
#### Fixed
fix: impossible to upload docs on ie11

#### Added
feature: export for inbound invoices for support #addw-1231 (#2471)
feature: adding documents for new legal forms #addw-1201 (#2446)

#### Changed
feature: removing accents from sogetrel password csv export #addw-1218 (#2484)

### [0.49.7] 2020-02-21
#### Fixed
fix: inbound invoices deadline selection
fix: dispatch event user registration during invitation (#2485)

### [0.49.6] 2020-02-21
#### Fixed
fix: change sentry log level to error in config (#2482)
fix: update inbound invoice

### [0.49.5] 2020-02-20
#### Fixed
fix: add some test for invitation + fix enterprise member remove accidentally accesse (#2477)

#### Added
feature: add contracts.external_identifier #addw-1237 (#2478)

### [0.49.4] 2020-02-19
#### Fixed
* fix: edenred mission offer show
* fix: enterprise member remove accidentally accesse, add some test for invitation
* fix: document policy test
* fix: document update policy
* fix: disabling inspector for phpunit (#2479)

#### Changed
* feature: softdelete user for support #addw-1220 (#2456)
* feature: split inboud invoice create form #addw-1229 (#2458)
* feature: giving access to sogetrel members to see vendors enterprises #addw-1236 (#2474)

#### Added
* feature: new roles for mission offer #addw-1227 (#2454)
* chore: update sentry configuration (#2469)
* chore: installing inspector.dev

### [0.49.3] 2020-02-17
#### Fixed
* fix: sanitize enterprise name before validation #1252
* fix: unable to add user to enterprise by support (#2473)
* fix: onboarding process passwork creation step

#### Changed
* feature: accessing proposals from an enterprise which is vendor & customer at the same time #addw-1239 (#2472)
* feature: change wording of offer closing mail #addw-1240 (#2467)

#### Added
* feature: adding selectpicker and search to contract create view #addw-1238 (#2470)

### [0.49.2] 2020-02-12
#### Fixed
* fix: synchronize navibat policy (#2466)

### [0.49.1] 2020-02-12
#### Added
* feature: adding everial analytical codes #addw-1248
* feature: adding purchase order notification for referent of offer #addw-1243 (#2465)
* feature: send response notification to referent of offer #addw-1245 (#2462)

#### Changed
* feature: Improvements for invitations + prevent user for removing all roles (#2464)
* feature: customer job inheritance #addw-1249

#### Fixed
* fix: proposal response repository

#### Removed
* feature: remove alert for to sign contracts on dashboard #addw-1244 (#2463)

### [0.49.0] 2020-02-11
#### Added
* feature: add button to show enterprise view to synchronize sogetrel vendor with navibat #addw-1241 (#2459)
* feature: members & vendor invites (#2457)

#### Changed
* feature: remove scmdo mail on sharing passwork #addw-1246 #2460

#### Removed
* chore: removing unecessary files

### [0.48.5]
#### Fixed
* fix: inbound invoice edit & show #addw-1226 (#2453)
* fix: update timeout for megatron (#2452)

#### Changed
* feature: block upload inbound invoice if vendor has not iban #addw-1214 (#2448)

### [0.48.4]
#### Fixed
* fix: support can delete passwork #addw-1219 (#2451)
* fix: signature on emails #addw-1217 (#2449)
* fix: mission closing ability by vendor #boyscout #addw-1224 (#2447)

#### Added
* feature: everial analytic code #addw-1126 (#2450)

### [0.48.3]
#### Fixed
* fix: skill routes #addw-1225
* fix: outbound invoice attachment on inbound updates #addw-1194
* fix: enterprise member controller test (#2445)
* fix: iban confirmation email (#2443)

#### Added
* feature: new testing request factory
* feature: enterprise member management (#2429)

### [0.48.2]
#### Fixed
* fix: vendor is ready to work for customer

### [0.48.1] - 2020-01-30
### Fixed
* fix: access to answer proposal for sogetrel (#2441)
* fix: missing parameters for edenred proposal route (#2440)

### [0.48.0] - 2020-01-29
#### Fixed
* fix: file create blade template (#2437)
* fix: conformity status of vendors (#2436)
* fix: Missing part during documents migrations (#2434)
* fix: mistape on widget missions #addw-1223 (#2433)
* fix: make-model classnames

#### Added
* feature: adding more information in the purchase order index view #addw-1222 (#2432)
* feature: better handling information requests for sogetrel #addw-1177 (#2420)
* feature: disabled proposal response button for enterprises documents non-compliant #addw-1199 (#2421)

### [0.47.4] - 2020-01-23
#### Fixed
* fix: database seeder, drop before import (#2426)
* fix: outbound invoice assoc is now performed in repo
* fix: remove obsolete test

#### Added
* feature: Multiple files associated to one documents (#2402)
* feature: create deadline type structure for invoices #addw-1207 (#2419)                                                                                                                        
* feature: access sogetrel passworks from response index

#### Changed
* chore: add env variable to env.example (#2424)                                                                                                                                      
* feature: seed database using db dump (#2376) 

### [0.47.1] - 2020-01-16
#### Fixed
* fix: create milestone when the mission is created from offer #addw-1205 (#2416)
* fix: enterprise show gate

#### Added
* feature: attaching vendors to customer when accepting their passwork #addw-1186 (#2412)
* feature: proposal answer button disabled for closed offers #addw-1198 (#2411)

#### Changed
* chore: updating codeowners
* refactor: change password page #addw-1197
* feature: remove account validation alert #addw-1202 (#2410)
* feature: link to mission on mission tracking index #addw-1203
* feature: refactoring inbound invoice system add invoiceable and vat_rate structure #addw-1163 (#2407)
* feature: updating the show view of the offer #addw-960 (#2405)
* feature: change rules of enterprise documents conformity #addw-1183 #2403

### [0.47.0] - 2020-01-13
#### Fixed
* fix: mission milestones creation
* fix: acces to vendor management view #addw-1192 (#2401)

#### Added
* feature: create tracking line index view for support #addw-1153 (#2385)
* feature: adding csv export for onboarding process #addw-1182 (#2394)

#### Changed
* feature: remove proposal system for sogetrel #addw-1187 (#2386)

### [0.46.5] - 2020-01-09
#### Fixed
* fix: listing proposals with link for responses to each proposal in the offer show view #addw-1191 #2396
* fix: customer filter in support document index view #addw-1179 (#2397)

#### Added
* feature: adding more details in the purchase order information part #addw-1178 (#2399)

#### Changed
* feature: change policies of everial mission referential #addw-1185 (#2392)

### [0.46.4] - 2020-01-08
#### Fixed
* fix: handling sogetrel vendors without passworks in index/show views #addw-1190 (#2395)

### [0.46.3] - 2020-01-08
#### Fixed
* fix: mission close policy #addw-1189 (#2389)
* fix: continuous integration
* fix: consistency tests

#### Added
* feature: reminding sogetrel users to finish their onboarding #addw-1165 #2368
* feature: harmonize the breadcrumb of inbound invoice for vendors #addw-1180 #2391
* feature: adding notification for new inbound invoice uploaded #addw-1184 (#2390)

#### Changed
* chore: bumping addworking/laravel-models to v1.2
* chore: composer update

### [0.46.2] - 2020-01-06
#### Fixed
* fix: edenred mission diffusion #addw-1188 (#2384)

#### Added
* feature: adding bpu for proposal of sogetrel #addw-1167 (#2382)

#### Removed
* feature: remove accept and decline methods for sogetrel #addw-1188 (#2383)

### [0.46.1] - 2019-12-31
#### Fixed
* fix: document csv builder

### [0.46.0] - 2019-12-30
#### Added
* feature: add new attribute siren to xml export for sogetrel #addw-1181 (#2379)
* feature: sending mail for mission tracking #addw-1145 (#2347)
* feature: adding rpg definition to process (#2374)

#### Changed
* feature: moving the comments into the the tracking show view #addw-1164 (#2378)
* feature: change sending notification for incomplete  onboarding process #addw-1166 (#2377)
* feature: modification of CSV export passworks sogetrel (#2372)

### [0.45.7] - 2019-12-18
#### Fixed
* fix: multiple minor bug (#2373)

#### Added
* chore: adding wip limit to process (#2369)

### [0.45.6] - 2019-12-18
#### Added
* support can update contract signatories #boyscout #addw-1119 (#2316)

#### Changed
* removing link from document requester #addw-1173 (#2370)

### [0.45.5] - 2019-12-17
#### Fixed
* proposal response validation test
* file factory minor bug

### [0.45.4] - 2019-12-17
#### Fixed
* create outbound invoice balance

#### Added
* getting purchase_order informations for the direct assignation of a mission #addw-1142 (#2361)

### [0.45.3] - 2019-12-17
#### Fixed
* store model file of document type (#2367)
* remove old title to mission tracking edit view (#2365)

### [0.45.2] - 2019-12-16
#### Fixed
* method put in update mission offer form (#2364)

### [0.45.1] - 2019-12-16
#### Fixed
* route in edit mission offer #addw-1171 (#2363)

### [0.45.0] - 2019-12-16
#### Added
* new parts for bin/make-model.sh

### [0.44.16] - 2019-12-12
#### Fixed
* use app()->make() to call document repository in uploadlegaldocument class (#2359)
* document repository construct method (#2358)

### [0.44.15] - 2019-12-12
#### Added
* comment document rejection #addw-1150 (#2356)

#### Fixed
* views titles
* display mission tracking create view (#2355)

### [0.44.14] - 2019-12-11
#### Added
* create index of inbound invoice for support #addw-1149 (#2354)

#### Fixed
* outbound invoice payment order html view

### [0.44.13] - 2019-12-10
#### Added
* adding export documents csv #addw-1146
* adding more test to enterprise class

#### Changed
* upadting hooks

#### Fixed
* mission offer create view title
* bugs introduced by viewable and routable traits

### [0.44.12] - 2019-12-09
#### Changed
* add @ to compact call + update php version to 7.3 in composer.json (#2352)
* return to the line in the comments #addw-1148 (#2353)
* shorten actions between finale validation response and close offer #addw-1082
* refactoring document views

#### Removed
* remove onboarding process steps #addw-1140 (#2332)

#### Fixed
* functionality to save passworks searches #addw-1157 (#2349)
* attachment mission tracking #addw-1144 (#2340)
* purchase order store
* status of mission tracking #addw-1130 (#2343)

### [0.44.11] - 2019-12-09
#### Added
* feature: add download documents zip of vendor #addw-1147 (#2345)
* feature: improvment in mission referential system #addw-1159 (#2346)
* feature: manual cps2 creation (#2342)


### [0.44.10] - 2019-12-06
#### Fixed
* fix: refactor sidebar menu views #addw-1143 (#2337)

#### Added
* feature: add tag double check #addw-1133 (#2329)
* feature: add my passworks entry to the imenu (#2313)
* feature: redirect to mission tracking after closed mission #addw-1129 (#2308)

### [0.44.9] - 2019-12-04
#### Fixed
* fix: action button in show views

#### Added
* feature: adding basic filter on mission offer broadcast

### [0.44.8] - 2019-12-04
#### Fixed
* hotfix: passwork index view not available (#2335)
* fix: date input polyfill for edge and safari
* fix: billing routables and viewable models

### [0.44.7] - 2019-12-04
#### Fixed
* hotfix: sogetrel passwork actions dropdown (#2333)

### [0.44.6] - 2019-12-03
#### Fixed
* fix: show payment order (#2331)

### [0.44.5] - 2019-12-03
#### Fixed
* fix: payment order show views (#2330)

### [0.44.4] - 2019-12-03
#### Fixed
* hotfix: acces to inbound invoice show view (#2327)

### [0.44.3] - 2019-12-03
#### Fixed
* fix: links in edenred code index and show views (#2325)
* fix : broken paths #addw-1156 (#2324)
* fix: fixing sogetrel path for passwork (#2326)

#### Added
* feature: new support docs index #addw-1098 (#2318)

### [0.44.2] - 2019-12-02
#### Fixed
* hotfix: revert old system of outbound invoice comments #addw-1139 (#2323)
* fix: offer show #addw-1155 (#2322)

### [0.44.1] - 2019-12-02
#### Fixed
* fix: migration document types to ancestors (#2321)

### [0.44.0] - 2019-12-02
#### Fixed
* fix : onboarding creation
* fix: updating commit-msg git hook

#### Added
* feature: get documents types of customers ancestors in index of documents #addw-1131 (#2317)
* feature: send the purchase order by mail to the vendor #boyscout #addw-1127 (#2306)
* feature: sending mail every 3 days to vendors who had unfinished onboarding process #boyscout #addw-1132 (#2314)
* feature: adding routable::has method

#### Changed
* feature: hide iban menu entry for customer #addw-1118 (#2315)

#### Removed
* chore: removing unecessary commands
* chore: removing hasviews trait

### [0.43.4] - 2019-11-26
#### Changed
* feature: disabling cps2 auto-generation
* feature: disabling cps2 and iban onboarding process steps

### [0.43.3] - 2019-11-21
#### Fixed
* fix: updating purchase_order to handle the assigning of offer directly to vendor #addw-1137 (#2311)
* fix: enterprise create and edit view #addw-1136 (#2310)

### [0.43.2] - 2019-11-21
#### Fixed
* fix: enterprise create and edit view #addw-1136 (#2310)

### [0.43.1] - 2019-11-21
#### Changed
* feature: display management call for tender menu for everial #addw-1126 (#2303)
* feature: create a mission form offer #addw-1095 (#2304)
* feature: number mission on index #addw-1128 (#2305)
* feature: updating purchase_order #boyscout #addw-1097 (#2292)
* feature: enhancements of viewable trait

### [0.43.0] - 2019-11-20
#### Changed
* feature: new omnisearch
* feature: add step create passwork in onboarding addworking #addw-1125 (#2302)
* feature: support can now see customers directly from enterprise show
* feature: adding params to routable models

#### Fixed
* fix: translate route name in snake_case in routable trait

### [0.42.8] - 2019-11-14
#### Changed
* chore: moving routes to corresponding service provider
* feature: migrate a index view of onboarding processes to new template #addw-1090 (#2299)

#### Removed
* feature: deleting mission tracking mode in mission edit #addw-1102 (#2298)
* feature: hide certificates menu entry when user is not at document upload step #addw-1048 (#2245)

### [0.42.7] - 2019-11-13
#### Fixed
* fix: commands errors

### [0.42.6] - 2019-11-13
#### Changed
* chore: massive console commands refactoring
* feature: end of mission by default mission traking create #addw-1080 (#2294)

### [0.42.5] - 2019-11-12
#### Fixed
* fix: document:send-to-storage command now takes trashed docs too
* fix: output display in continuous integration

#### Added
* feature: adding document:send-to-storage command
* feature: adding descendants method for enterprise

### [0.42.4] - 2019-11-12
#### Fixed
* fix: automatic change status of proposal response edenred #addw-1052 (#2290)
* fix: support can replace the contract attached file #addw-988 (#2279)

#### Added
* feature: soconnext tag on enterprise view #addw-1089 (#2268)
* infrastructure: adding s3 storage for documents
* feature: adding starts at desired attribute to proposal index #addw-1083 (#2275)
* feature: new comment system and comment when changing status outboundinvoice #addw-1100 (#2286)
* feature: migration old comments outbound_invoices in new comment system #addw-1117 (#2291)

#### Changed
* feature: hide convention & testimonials in menu for customer #addw-1085 (#2269)

### [0.42.3] - 2019-11-07
#### Fixed
* fix: migration old passwork comments whose author no longer exist (sogetrel) (#2288)

### [0.42.2] - 2019-11-07
#### Fixed
* fix: payment order store uri in view create #addw-1116 (#2285)
* fix: pre-commit test test to ignore tests classes
* fix: update inbound_invoice #addw-1062 (#2282)
* fix: ignore classes that do not need to have a test (#2284)

#### Added
* feature: sogetrel members can now access sogetrel data #addw-1099
* feature: migration old passwork comments whose author no longer exist #addw-1087 (#2266)
* feature: adding support domain #boyscout #addw-1091 (#2254)

#### Changed
* feature: improvments in index view of documents #addw-1076 (#2259)

#### Removed
* feature: removing redirection to TL create view when a TL is refused #addw-1079 (#2277)

### [0.42.1] - 2019-11-05
#### Fixed
* fix: overriding getKeyType() method in [laravel-has-uuid](https://github.com/addworking/laravel-has-uuid) package to avoid adding the property $keyType into each model

### [0.42.0] - 2019-11-05
#### Fixed
* fix: change comment status default value to public #addw-1112 (#2278)
* fix: add file referntial_everial (#2264)

#### Added
* feature: giving vendors the possibility to ask referents for information in proposals #boyscout #addw-1086 (#2256)
* feature: resend proposal mission #addw-1074 (#2252)

#### Changed
* infrastructure: upgrade to laravel 6 #addw-1067 (#2276)
* chore: updating components
* chore: changes in cps2
* chore: better pre-commit hook summary

#### Removed
* feature: remove objectives attribute from mission offer #addw-1084 (#2272)

### [0.41.3] - 2019-10-31
#### Fixed
* access to mission offer with old menu template (#2274)

### [0.41.2] - 2019-10-30
#### Fixed
* losing vendor type when updating the enterprise #boyscout #addw-1105 (#2271)

#### Added
* new continuous integration script (#2265)

#### Changed
* improvement in view my vendors #addw-1057 (#2250)
* moving some helpers into controllers

### [0.41.1] - 2019-10-25
#### Fixed
* restore configuration without passport #addw-1093 (#2263)
* listing all customers offers #boyscout #addw-1059 (#2224)
* export csv outbound invoice tse #addw-1041 (#2244)

#### Added
* import referential missions of everial #addw-1023 (#2228)
* mission traking line in mission traking create #addw-1081 (#2258)
* adding new mission menu for everial #addw-1078 (#2260)

#### Changed
* updating seeders #addw-1092 (#2257)
* normalizing route names and uris for documents #boyscout #addw-1063 (#2237)
* policies passwork #addw-1043 (#2220)
* adding select with search in create offer view #addw-1050 (#2232)

### [0.41.0] - 2019-10-22
#### Fixed
* email confirmation 404

#### Added
* email verification test 
* reinforcing registration tests
* registration test
* refactoring index view of my vendors #addw-1053 (#2235)

### [0.40.4] - 2019-10-17
#### Fixed
* fix: hasstatus trait filename

#### Added
* feature: user manual password reset

### [0.40.3] - 2019-10-16
#### Fixed
* fix: show my attestations (#2242)

#### Added
* feature: vendor csv loader now sends notification to created users
* feature: mission proposal resend #addw-1058 (#2233)

### [0.40.2] - 2019-10-15
#### Fixed
* fix: repair customers view #addw-1061 (#2236)
* fix: vendor csv loader address country validation

#### Added
* feature: document description on document index view #addw-1044 (#2234)
* feature: to hide my certificates in menu according to step onboarding #addw-1048 (#2230)
* feature: date of deposit of documents on index documents view #addw-1046 (#2225)
* feature: show passwork corresponding to the subdomain #addw-1055 (#2229)

### [0.40.1] - 2019-10-14
#### Fixed
* fix: wording
* fix: csv loader serialization of exceptions
* fix: make-model controller generation
* fix: make-model migration creation
* fix: redirect to proposal response after create an offer #addw-1051 (#2223)
* fix: disabling routes consistency checks

#### Added
* feature: csv loader report show
* feature: cleanup method is now mandatory for csv loaders
* feature: csv loader reports index
* feature: adding label column to csv loader report
* feature: csv loader report model
* feature: csv loaders serilization
* feature: adding logging to csv loader
* feature: make-model now generates show
* feature: make-model now generates actions
* feature: make-model now generates index
* feature: new make-model command
* feature: adding comments for documents #addw-1047 (#2221)
* feature: clean-up statuses of mission #addw-1049 (#2231)
* feature: adding condition for display model of document type #addw-1045 (#2219)
* mapping coverage zones to departments
* feature: multi-select on spie coverage zones

#### Changed
* feature: normalizing routes #boyscout #addw-1027 (#2212)

### [0.40.0] - 2019-10-07
#### Fixed
* fix: attach vendor to customer and reorganize enterprise model #addw-1033 (#2210)

#### Added
* feature: adding mails for mission offer closed #addw-998 (#2207)
* feature: create specific view for everial to select who receive mission offer #addw-1024 (#2204)
* feature: notification to share sogetrel passwork #addw-984 (#2181)

#### Changed
* chore: adding rules for testing in process guide (#2218)
* chore: reverting test database to sqlite_testing
* chore: minor changes in process.md
* chore: updating processes

### [0.39.2] - 2019-10-02
#### Fixed
* chore: adding temp repository
* fix: unique constraint to the name of enterprises addw-1016 (#2197)

#### Added
* feature: adding permission for purchase orders #addw-1026 (#2209)
* feature: notifying the mission-offer owner when a new proposal response is submitted #addw-996 (#2202)
chore: adding process guide

#### Changed
* chore: cleanup

### [0.39.1] - 2019-10-01
#### Fixed
* fix: admin right for first user of a enterprise #1020 (#2205)
* fix: attaching phone number to vendor when it is created by a customer #addw-1012 (#2182)
* fix: unit test when using postgresql
* fix: unique constraint referencing a user to enterprise #addw-1031 (#2208)

#### Added
* feature: adding new button for operators in offer mission edenred #addw-1022 (#2203)
* feature: sending email to julie@addworking.com when a passwork is accepted #addw-999 (#2196)
* feature: sending email to mission-offer referent when the status becomes ok_to_meet #addw-997 (#2198)
* feature: sending email to conformite@addworking.com when a document is uploaded #boyscout #addw-993 (#2192)
* feature: documents expiration command #addw-995 #addw-994 (#2188)
* feature: create enterprises for existing passwork #addw-867 (#2184)
* feature: vendor csv import #addw-739
* feature: spie import and search engine

#### Changed
* chore: updating seeders #addw-1029 (#2206)
* chore: updating code owners rules

### [0.39.0] - 2019-09-24
#### Fixed
* fix: fatal error on onboarding_process.index search #sentry-addworking-e6
* fix: remove passwork edenred from onboarding (#2200)

#### Added
* feature: create a specific mission offer views for everial #addw-1007 (#2194)
* feature: index view for everial mission referential price list #addw-1009 (#2190)
* feature: can add tag so connext on vendor #addw-970 (#2191)

#### Changed
* feature: disabling a user instead of removing it #addw-983 (#2177)

### [0.38.5] - 2019-09-19
#### Fixed
* fix: offer proposal removed from show #addw-1019
* fix: sogetrel vendors proposal index #addw-1018
* fix: sogetrel vendorship attachment #stack-overflow-60

#### Added
* feature: add zipcode filter to sogetrel passwork #addw-982 (#2189)
* feature: migration for everial price list #addw-1006 (#2186)
* feature: destroy action for everial referential missions #addw-1004 (#2180)

### [0.38.4] - 2019-09-16
#### Fixed
* fix: actions tracking migration in comments system #addw-1013 (#2185)

### [0.38.3] - 2019-09-13
#### Fixed
* fix: contract synchronize job #rd-12
* fix: remove impersonate customers (#2175)

#### Added
* feature: edit view for everial referential missions #addw-1005 (#2179)
* feature: adding button for navibat synchronization by support #addw-794 (#2178)
* feature: adding purchase_order index view with filters #boyscout #addw-883 (#2156)
* feature: index view for everial referential missions #addw-1001 (#2176)
* feature: adding widget in customer dashboard for new responses #addw-991 (#2172)
* feature: adding unit days by default for proposal responses #addw-987 (#2174)
* feature: user swaps enterprises
* feature: show view for everial referential missions addw-1003 (#2169)
* feature: adding widget for mission proposals on dashboard #addw-992 (#2171)
* chore: adding codeowners
* feature: create migration model and create view for everial referential missions #addw-1000 (#2162)

#### Changed
* feature: actions tracking migration in sogetrel comments system #addw-981 (#2167)
* chore: updating seeders #addw-1011 (#2170)
* chore: error messages are no longer encoded for support

### [0.38.2] - 2019-09-10
#### Fixed
* fix: fixing route for store mission tracking #addw-973 (#2164)
* fix: inbound invoice helpers and store request #rd-10 #rd-11
* fix: contract log helper #addw-986 (#2158)

### [0.38.1] - 2019-09-10
#### Fixed
* fix: remove edenred relation with proposal responses #addw-985 (#2161)
* fix: bad use of offer helper instead of mission_offer
* chore: boyscout cleanup and fixes

#### Added
* feature: adding impersonnate for customers #addw-944 (#2150)

#### Removed
* chore: removing forges

### [0.38.0] - 2019-09-09
#### Fixed
* fix: tse express medical outbound invoice csv export
* fix: adding label to mission tracking create breadcrumb #addw-972 (#2159)
* chore: many fixes suggested by phpstan
* fix: login background color on microsoft edge
* fix: mission model function alias mission_offer
* fix: sogetrel so'connext welcome message
* fix: laravel-models crashes the app on boot

#### Added
* chore: adding phpstan to git pre-commit hook
* chore: adding classname duplicate test
* chore: adding model repository test
* chore: adding models policy test
* chore: adding addworking/laravel-class-finder package
* feature: adding remove capability for purchase orders #addw-887 (#2154)
* feature: adding generate purchase order button for mission #addw-810 #boyscout (#2139)
* feature:adding amount to show mission #addw-957 (#2149)
* feature: creating test for table names
* feature: adding offer model and repository for everial #addw-906 (#2151)

#### Changed
* chore: relocating classname uniqueness test in its own scenario
* refactor: moving helpers to addworking/laravel-models

#### Removed
* feature: remove message for new look to everyone #addw-990 (#2160)
* feature: remove everial migration and model (#2157)

### [0.37.3] - 2019-08-30
#### Fixed
* fix: customer can now change inbound invoice status #rd-9
* fix: making milestone type null by default in mission #addw-947 (#2145)

#### Added
* feature: adding upload legal documents to onboarding process #addw-200 (#2143)

### [0.37.2] - 2019-08-29
#### Fixed
* fix: download button on payment order view #rd-8
* fix: configuring test to run on  a different database #addw-976 (#2144)
* fix: pre-commit hook

#### Added
* feature: add referent in mission offer #boyscout #addw-938 #addw-939 (#2142)
* feature: set status after comparing average daily rate to unit price #addw-940 (#2138)
* feature: adding comments for responses statuses #addw-470 (#2136)
* feature: add link for determinate milestone type #addw-956 (#2141)

#### Changed
* chore: renaming some tests

### [0.37.1] - 2019-08-27
#### Fixed
* fix: inbound invoice status change #rd-6
* fix: disable post-install script in heroku #addw-971 (#2137)

#### Added
* feature: purchase_order show view #addw-886 #boyscout (#2124)
* feature: new git hooks!

#### Changed
* feature: changing redirect to user index at login with support #addw-943 (#2134)
* feature: wording in mission offer status #addw-941 (#2129)
* feature: display filters on index #addw-946 (#2133)
* feature: wording in mission profile create #addw-953 (#2128)
* feature: wording in mission proposal_response #addw-959 (#2130)
* feature: show mission-proposals url without the s at the end #addw-954 (#2131)
* refactor: beautifying database/migrations
* chore: refactoring consistency test suite

#### Removed
* chore: removing old commit hooks

### [0.37.0] - 2019-08-26
#### Fixed
* fix: translating average daily rate (#2132)
* fix: add removed use for the notification class #addw-966 (#2127)
* fix: inbound invoice edit #rd-1

#### Changed
* chore: upgrading packages

### [v0.36.9] - 2019-08-23
#### Fixed
* fix: outbound invoice vendor cps3 name determination #rd-3
* fix: remove old method addresses for user #addw-950 (#2126)

### [v0.36.8] - 2019-08-23
#### Fixed
* chore: upgrading javascript packages

### [v0.36.7] - 2019-08-21
#### Fixed
* fix: ussage of models in migrations
* chore: adding test for verify use in migrations
* chore: fixing namespace issues
* chore: adding namespace consistency unit test
* fix: minor pathes for views
* fix: removing 'actions(...)' call from views
* fix: contract template views (#no-actions)
* fix: minor improvement of no-actions test
* chore: cleaning and updating seeders #addw-936 (#2123)
* fix: vendor dashboard inbound invoices link
* refactor: contract
* refactor: file
* fix: invalid routes in billing models
* chore: removing old inbound invoice export system
* chore: removing old inbound invoice routes

#### Added
* feature: test for 'action(...)' in views
* feature: better error pages
* feature: changing total_amount to quantity in proposal_response model #addw-925 (#2121)

### [v0.36.6] - 2019-08-21
#### Fixed
* fix: authenticated user check should be secured by auth check

### [v0.36.5] - 2019-08-21
#### Fixed
* chore: updating composer.lock

### [0.36.4] - 2019-08-20
### Fixed
* fix: inbound invoice creation by vendor

### Added
* feature: adding create site #addw-889 (#2108)

### [0.36.3] - 2019-08-19
### Fixed
* fix: adding condition for attach vendor to customer #addw-881 (#2119)
* fix: partials without a connected user
* fix: inbound invoice store route in create view

### Added
* feature: adding analytic_code attribute to mission offer #addw-896 (#2116)
* feature: adding departments columns to sogetrel password export #addw-929 (#2117)
* feature: improving forgot password email #addw-350 (#2110)
* feature: button to transform responses to missions #addw-811 (#2095)
* feature: reverting inbound invoice file association
* feature: reverting outbound invoice file association

### [0.36.2] - 2019-08-13
#### Fixed
* fixing invoices status display #addw-933 (#2111)

### [0.36.1] - 2019-08-13
#### Fixed
* fixing invoices status display #addw-933 (#2111)

### [0.36.0] - 2019-08-12
#### Fixed
* viewable namespace (#2107)
* removing useless views

#### Added
* add column created at to index offer (#2105)
* viewable models

### [0.35.4] - 2019-08-07
#### Fixed
* outbound invoice filename generation #addw-879 (#2096)

#### Added
* create factories & routes for models (#2055)

### [0.35.3] - 2019-08-05
#### Fixed
* refactoring edenred routes (#2081)
* standardization of all mission process (#2097)

#### Changed
* redirect to create new tracking line if status refused #addw-858 (#2094)
* disable button for tracking line if there is status #addw-856 (#2092)
* allow to change the phone number of an enterprise #addw-788 (#2056)
* edenred onboarding passwork step #addw-752 (#2058)
* adding status for tracking  if tracking line validated once #addw-814 (#2088)
* adding status for self validation on creating tracking line #addw-852 (#2086)
* refactoring the index proposal response table addw-837 (#2084)

#### Added
* create a milestone type view from a mission #addw-865 (#2098)
* add reason for rejection to proposal response #addw-850 (#2093)
* adding summary to the closed offers #addw-864 (#2091)
* add button create in mission index view #addw-851 (#2083)
* Adding a badge to the new created missions #addw-866 (#2070)
* add reason of rejection in modal when reject mission tracking line #addw-813 (#2082)
* adding summary listing for responses at closing of offer #addw-809 (#2080)

### [0.35.2] - 2019-08-01
#### Fixed
* enlarge the clic area of the action button (#2078)
* allowing access to mission tracking index for the customer #addw-857 (#2072)

#### Changed
* stabilization of mission proposal details #addw-804 (#2067)
* change column starts_at of mission offer #addw-805 (#2077)
* standardizing proposal tab in offer vue #addw-803 (#2075)
* normalize mission profile route #addw-820 (#2073)
* normalization of proposal response routes #addw-835 (#2071)
* modification steps onboarding sogetrel #addw-571 (#2062)
* update database seeders #addw-875 (#2069)

#### Added
* create csv builder export for user logs #addw-728 (#2074)
* create platform's changelog (#2068)
* implement comment in mission tracking model #addw-815 (#2076)

### [0.35.1] - 2019-07-30
#### Fixed
* inbound invoice download from outbound validation page (again) #addw-874

#### Changed
* fill the help section in mission tracking show #addw-812 (#2066)
* stabilization of response mission offer #addw-844 (#2060)
* change visibility of comments sogetrel passwork to public #addw-871 (#2065)
* stablization proposal profiles #addw-802 (#2063)
* add data to sogetrel passwork csv export #addw-873 (#2061)



