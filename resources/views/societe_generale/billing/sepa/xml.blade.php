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
            @foreach($creditTransferTransactionInformations as $creditTransferTransactionInformation)
                <CdtTrfTxInf>
                    <PmtId>
                        <InstrId>{{ $creditTransferTransactionInformation['paymentIdentification']['instructionIdentification'] }}</InstrId>
                        <EndToEndId>{{ $creditTransferTransactionInformation['paymentIdentification']['endToEndIdentification'] }}</EndToEndId>
                    </PmtId>
                    <Amt>
                        <InstdAmt Ccy="EUR">{{ $creditTransferTransactionInformation['amount_before_taxes']['instructedAmount'] }}</InstdAmt>
                    </Amt>
                    <CdtrAgt>
                        <FinInstnId>
                            <BIC>{{ $creditTransferTransactionInformation['creditorAgent']['financialInstitutionIdentification']['bic'] }}</BIC>
                        </FinInstnId>
                    </CdtrAgt>
                    <Cdtr>
                        <Nm>{{ $creditTransferTransactionInformation['creditor']['name'] }}</Nm>
                    </Cdtr>
                    <CdtrAcct>
                        <Id>
                            <IBAN>{{ $creditTransferTransactionInformation['creditorAccount']['identification']['iban'] }}</IBAN>
                        </Id>
                    </CdtrAcct>
                    <RmtInf>
                        <Ustrd>{{ $creditTransferTransactionInformation['remittanceInformation']['unstructured'] }}</Ustrd>
                    </RmtInf>
                </CdtTrfTxInf>
            @endforeach
        </PmtInf>
    </pain.001.001.02>
</Document>