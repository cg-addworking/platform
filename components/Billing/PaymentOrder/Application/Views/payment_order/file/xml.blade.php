{!! '<'.'?'.'xml version="1.0" encoding="UTF-8" standalone="no" ?>' !!}
<Document xmlns="urn:iso:std:iso:20022:tech:xsd:pain.001.001.02">
    <pain.001.001.02>
        <GrpHdr>
            <MsgId>{{ $groupHeader['messageIdentification'] }}</MsgId>
            <CreDtTm>{{ $groupHeader['creationDateTime'] }}</CreDtTm>
            <NbOfTxs>{{ $groupHeader['numberOfTransactions'] }}</NbOfTxs>
            <CtrlSum>{{ $groupHeader['controlSum'] }}</CtrlSum>
            <Grpg>{{ $groupHeader['grouping'] }}</Grpg>
            <InitgPty>
                <Nm>{{ $groupHeader['initiatingParty']['name'] }}</Nm>
            </InitgPty>
        </GrpHdr>
        <PmtInf>
            <PmtInfId>{{ $paymentInformation['paymentInformationIdentification'] }}</PmtInfId>
            <PmtMtd>{{ $paymentInformation['paymentMethod'] }}</PmtMtd>
            <PmtTpInf>
                <SvcLvl>
                    <Cd>{{ $paymentInformation['paymentTypeInformation']['serviceLevel']['code'] }}</Cd>
                </SvcLvl>
            </PmtTpInf>
            <ReqdExctnDt>{{ $paymentInformation['requestedExecutionDate'] }}</ReqdExctnDt>
            <Dbtr>
                <Nm>{{ $paymentInformation['debtor']['name'] }}</Nm>
            </Dbtr>
            <DbtrAcct>
                <Id>
                    <IBAN>{{ $paymentInformation['debtorAccount']['identification']['iban'] }}</IBAN>
                </Id>
            </DbtrAcct>
            <DbtrAgt>
                <FinInstnId>
                    <BIC>{{ $paymentInformation['debtorAgent']['financialInstitutionIdentification']['bic'] }}</BIC>
                </FinInstnId>
            </DbtrAgt>
            <UltmtDbtr>
                <Nm>{{ $paymentInformation['ultimateDebtor']['name'] }}</Nm>
            </UltmtDbtr>
            @foreach($transferTransactionInformations as $transferTransactionInformation)
                <CdtTrfTxInf>
                    <PmtId>
                        <InstrId>{{ $transferTransactionInformation['paymentIdentification']['instructionIdentification'] }}</InstrId>
                        <EndToEndId>{{ $transferTransactionInformation['paymentIdentification']['endToEndIdentification'] }}</EndToEndId>
                    </PmtId>
                    <Amt>
                        <InstdAmt Ccy="EUR">{{ $transferTransactionInformation['amount']['instructedAmount'] }}</InstdAmt>
                    </Amt>
                    <CdtrAgt>
                        <FinInstnId>
                            <BIC>{{ $transferTransactionInformation['creditorAgent']['financialInstitutionIdentification']['bic'] }}</BIC>
                        </FinInstnId>
                    </CdtrAgt>
                    <Cdtr>
                        <Nm>{{ $transferTransactionInformation['creditor']['name'] }}</Nm>
                    </Cdtr>
                    <CdtrAcct>
                        <Id>
                            <IBAN>{{ $transferTransactionInformation['creditorAccount']['identification']['iban'] }}</IBAN>
                        </Id>
                    </CdtrAcct>
                    <RmtInf>
                        <Ustrd>{{ $transferTransactionInformation['remittanceInformation']['unstructured'] }}</Ustrd>
                    </RmtInf>
                </CdtTrfTxInf>
            @endforeach
        </PmtInf>
    </pain.001.001.02>
</Document>