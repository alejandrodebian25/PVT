<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{$file_title}}</title>
    <link rel="stylesheet" href="{{ public_path("/css/report-print.min.css") }}" media="all"/>
</head>
@include('partials.header', $header)
<body>
<div class="block">
    <div class="font-semibold leading-tight text-center m-b-10 text-base">
        {{$is_refinancing?'CONTRATO DE':'CONTRATO DE PRÉSTAMO'}} <font style="text-transform: uppercase;">{{ $title }}</font>
        <div>Nº {{ $loan->code }}</div>
    </div>
</div>
<?php $modality = $loan->modality;
if(($modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Activo' || $modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo AFP'|| $modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo SENASIR'|| $modality->name == 'Refinanciamiento de Préstamo a largo Plazo con un Solo Garante Sector Activo CPOP')){?>
<div class="block text-justify">
    <div>
        Conste en el presente contrato de {{ $title }}, que al solo reconocimiento de firmas y rúbricas ante autoridad competente será elevado a Instrumento Público, por lo que las partes que intervienen lo suscriben al tenor de las siguientes cláusulas y condiciones:
    </div>
    <div>
        <b>PRIMERA.- (DE LAS PARTES):</b> Intervienen en el presente contrato, por una parte como ACREEDOR la Mutual de Servicios al Policía (MUSERPOL), representada legalmente por su {{ $employees[0]['position'] }} {{ $employees[0]['name'] }} con C.I. {{ $employees[0]['identity_card'] }} y su {{ $employees[1]['position'] }} {{ $employees[1]['name'] }} con C.I. {{ $employees[1]['identity_card'] }}, que para fines de este contrato en adelante se denominará MUSERPOL con domicilio en la Z. Sopocachi, Av. 6 de Agosto Nº 2354 y por otra parte como

        @if (count($lenders) == 1)
        @php ($lender = $lenders[0]->disbursable)
        @php ($male_female = Util::male_female($lender->gender))
        <span>
            DEUDOR{{ $lender->gender == 'M' ? '' : 'A' }} {{ $lender->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $lender->full_name }}, con C.I. {{ $lender->identity_card_ext }}, {{ $lender->civil_status_gender }}, mayor de edad, hábil por derecho, natural de {{ $lender->city_birth->name }}, vecin{{ $male_female }} de {{ $lender->address->cityName() }} y con domicilio especial en {{ $lender->address->full_address }}, en adelante denominad{{ $male_female }} PRESTATARIO.
        </span>
        @endif
    </div>
    <div>
        <?php
        $modality = $loan->modality;
        if(($loan->data_loan)){ ?>
            <b>SEGUNDA.- (DEL ANTECEDENTE):</b>Mediante contrato de préstamo {{ $loan->data_loan->code }} SISMU con fecha de desembolso {{$loan->data_loan->disbursement_date? Carbon::parse($loan->data_loan->disbursement_date)->isoFormat('LL'):'_________________'}}, se ha suscrito entre MUSERPOL y el PRESTATARIO un préstamo por la suma de Bs.{{ Util::money_format($loan->data_loan->amount_approved) }} (<span class="uppercase">{{ Util::money_format($loan->data_loan->amount_approved, true) }} Bolivianos</span>), con garantía {{$is_active? 'de haberes':'de rentas o haberes'}} y garantía personal.
            <div>
            <b>TERCERA.- (DEL OBJETO):</b>  El objeto del presente contrato es el refinanciamiento del préstamo de dinero que MUSERPOL otorgó al PRESTATARIO conforme a calificación, previa evaluación y autorización, de conformidad a los niveles de aprobación respectivos en la suma de Bs.{{ Util::money_format($loan->refinancing_balance) }} (<span class="uppercase">{{ Util::money_format($loan->refinancing_balance, true) }} Bolivianos</span>), para lo cual el PRESTATARIO reconoce de manera expresa el saldo anterior de la deuda correspondiente al préstamo contraído con anterioridad, que asciende a la suma de Bs.{{ Util::money_format($loan->balance_parent_refi())}} (<span class="uppercase">{{ Util::money_format($loan->balance_parent_refi(), true) }} Bolivianos</span>), montos que hacen un total efectivo de Bs.{{ Util::money_format($loan->amount_approved) }} (<span class="uppercase">{{ Util::money_format($loan->amount_approved, true) }} Bolivianos</span>), que representa la nueva obligación contraída sujeta a cumplimiento, en función a la operación de refinanciamiento.
            </div>
            <?php }
        else{?>
            <div>
            <b>SEGUNDA.- (DEL ANTECEDENTE):</b>Mediante contrato de préstamo {{ $parent_loan->code }} con fecha de desembolso {{ Carbon::parse($parent_loan->disbursement_date)->isoFormat('LL') }} y modalidad de  {{strtolower($parent_loan->modality->name)}}, se ha suscrito entre MUSERPOL y el PRESTATARIO un préstamo por la suma de Bs.{{ Util::money_format($parent_loan->amount_approved) }} (<span class="uppercase">{{ Util::money_format($parent_loan->amount_approved, true) }} Bolivianos</span>), con garantía de haberes y garantía personal.
            </div>
            <div>
            <b>TERCERA.- (DEL OBJETO):</b>  El objeto del presente contrato es el refinanciamiento del préstamo de dinero que MUSERPOL otorgó al PRESTATARIO conforme a calificación, previa evaluación y autorización, de conformidad a los niveles de aprobación respectivos en la suma de Bs.{{ Util::money_format($loan->refinancing_balance) }} (<span class="uppercase">{{ Util::money_format($loan->refinancing_balance, true) }} Bolivianos</span>), para lo cual el PRESTATARIO reconoce de manera expresa el saldo anterior de la deuda correspondiente al préstamo contraído con anterioridad, que asciende a la suma de Bs.{{ $loan->balance_parent_refi()}} (<span class="uppercase">{{ Util::money_format($loan->balance_parent_refi(), true) }} Bolivianos</span>), montos que hacen un total efectivo de Bs.{{ Util::money_format($loan->amount_approved) }} (<span class="uppercase">{{ Util::money_format($loan->amount_approved, true) }} Bolivianos</span>), que representa la nueva obligación contraída sujeta a cumplimiento, en función a la operación de refinanciamiento.
            </div>
        <?php }?>
    </div>
    <div>
        <b>CUARTA.- (DEL INTERÉS):</b> El préstamo objeto del presente contrato, devengará un interés ordinario del {{ $loan->interest->annual_interest }}%, anual sobre saldo deudor, el mismo que se recargará con el interés penal, en caso de mora de una o más amortizaciones. Esta tasa de interés podrá ser modificada en cualquier momento de acuerdo a las condiciones financieras que adopte la MUSERPOL.
    </div>
    <div>
        <b>QUINTA.- (DEL DESEMBOLSO, DEL PLAZO Y LA CUOTA DE AMORTIZACIÓN):</b> El desembolso del préstamo se acredita mediante comprobante escrito en el que conste el abono efectuado a favor del PRESTATARIO, o a través de una cuenta bancaria del Banco Unión a solicitud del PRESTATARIO; reconociendo ambas partes que al amparo de este procedimiento se cumple satisfactoriamente la exigencia contenida en el artículo 1331 del Código de Comercio. El plazo fijo e improrrogable para el cumplimiento de la obligación contraída por el PRESTATARIO en virtud al préstamo otorgado es de {{ $loan->loan_term }} meses computables a partir de la fecha de desembolso. La cuota de amortización mensual es de Bs.{{ Util::money_format($loan->estimated_quota) }} (<span class="uppercase">{{ Util::money_format($loan->estimated_quota, true) }} Bolivianos</span>).
    </div>
    <div>
        Los intereses generados entre la fecha del desembolso del préstamo y la fecha del primer pago serán cobrados con la primera cuota; conforme los establece el Reglamento de Préstamos.
    </div>
    <div>
    <?php $modality = $loan->modality;
        if(($modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo AFP')){ ?>
        <b>SEXTA.- (DE LA FORMA DE PAGO Y OTRAS CONTINGENCIAS):</b> Para el cumplimiento estricto de la obligación (capital e intereses) el PRESTATARIO, se obliga a cumplir con la cuota de amortización en forma mensual mediante pago directo en la oficina central de la MUSERPOL de la ciudad de La Paz o efectuar el depósito en la cuenta bancaria de la MUSERPOL y enviar la boleta de depósito original a la oficina central inmediatamente; caso contrario el PRESTATARIO se hará pasible al recargo correspondiente a los intereses que se generen al día de pago por la deuda contraída. En caso de incumplimiento se procedera al descuento del garante personal incluidos los intereses penales pasados los dos meses sin necesidad de previo aviso.
        <?php }
        else{
            if($modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Activo'|| $modality->name =='Refinanciamiento de Préstamo a largo Plazo con un Solo Garante Sector Activo CPOP'){
                $quinta = 'Comando General de la Policía Boliviana';
            }
            if($modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo SENASIR'){
                $quinta = 'Servicio Nacional del Sistema de Reparto SENASIR';
            }
            ?>
        <b>SEXTA.- (DE LA FORMA DE PAGO Y OTRAS CONTINGENCIAS):</b> Para el cumplimiento estricto de la obligación (capital e intereses) el PRESTATARIO, autoriza expresamente a MUSERPOL practicar los descuentos respectivos {{$is_active? 'de los haberes':'de las rentas'}} que percibe en forma mensual a través del {{ $quinta }}.
        <div>
        Si por cualquier motivo la MUSERPOL estuviera imposibilitada de realizar el descuento por el medio señalado, el PRESTATARIO se obliga a cumplir con la cuota de amortización mediante pago directo en la Oficina Central de la MUSERPOL de la ciudad de La Paz o efectuar el depósito en la cuenta bancaria de la MUSERPOL y enviar la boleta de depósito original a la Oficina Central inmediatamente. <br>Caso contrario el PRESTATARIO se hará pasible al recargo correspondiente a los intereses que se generen al día de pago por la deuda contraída.
        </div>
        <div>
            Asimismo, el PRESTATARIO se compromete a hacer conocer oportunamente a MUSERPOL sobre la omisión del descuento mensual que se hubiera dado a efectos de solicitar al {{ $quinta }} regularice este descuento sin perjuicio que realice el depósito directo del mes omitido de acuerdo a lo estipulado en el párrafo precedente. Caso contrario se procedera al descuento a los garantes personales pasado los dos meses de incumplimiento sin necesidad de previo aviso.
        </div>
        <?php }?>
    </div>
    <div>
        <b>SÉPTIMA.- (DERECHOS DEL PRESTATARIO):</b> Conforme al artículo 29 del Reglamento de Préstamos las partes reconocen expresamente como derechos irrenunciables del PRESTATARIO, lo siguiente:
    </div>
    <div>
        <ol type="a">
            <li>Recibir buena atención, trato equitativo y digno por parte de los funcionarios de la MUSERPOL sin discriminación de ninguna naturaleza y/o por razones de edad, género, raza, religión o identidad cultural, con la debida diligencia según normativa legal vigente y las disposiciones internas de la entidad.</li>
            <li>A recibir los servicios prestados por la MUSERPOL en condiciones de calidez, calidad, oportunidad y disponibilidad, adecuadas a sus intereses económicos.</li>
            <li>A recibir por parte de la MUSERPOL, a través de sus funcionarios, información y orientación precisa en relación a: requisitos, características y condiciones del préstamo; que debe ser fidedigna, amplia, íntegra, clara, comprensible, oportuna y accesible; en caso de duda el afiliado podrá efectuar consultas, peticiones y solicitudes inherentes a los términos y condiciones contractuales del crédito, su situación financiera y legal emergente del mismo.</li>
            <li>A la confidencialidad, en el marco estricto de la normativa legal vigente y reclamar si el servicio recibido no se ajusta a lo previsto en la presente cláusula.</li>
            <li>Otros derechos reconocidos por disposiciones legales y/o reglamentarias, que no sean limitativos ni excluyentes.</li>
        </ol>
    </div>
    <div>
        <b>OCTAVA.- (OBLIGACIONES DEL PRESTATARIO):</b> Conforme al artículo 30 del Reglamento de Préstamos, las partes reconocen expresamente como obligaciones del PRESTATARIO, lo siguiente:
    </div>
    <div>
        <ol type="a">
            <li>Proporcionar a los funcionarios de la MUSERPOL, documentos legítimos, nítidos y legibles para la correcta tramitación de los mismos.</li>
            <li>Presentar documentos idóneos de todos los involucrados en el Préstamo solicitado.</li>
            <li>Cumplir con todos y cada uno de los artículos establecidos en el presente Reglamento de Préstamos.</li>
            <li>Cumplir con los requisitos, condiciones y lineamientos de Préstamo.</li>
            <li>Cumplir con el Contrato de Préstamo suscrito entre la MUSERPOL y el PRESTATARIO.</li>
            <li>Amortizar mensualmente la deuda contraída con la MUSERPOL, hasta cubrir el capital adeudado.</li>
            <li>Presentar toda documentación en los plazos previstos por el Reglamento.</li>
            <li>Honrar toda deuda pendiente con la MUSERPOL (no estar en mora, al momento de solicitar un nuevo préstamo y/o servicio).</li>
            <li>El deudor debe comunicar a la MUSERPOL, de forma escrita cualquier situación o contingencia. Incluso el cambio de domicilio.</li>
            <li>En el caso de los Garantes, los mismos se constituyen en la primera fuente de Repago del Préstamo, de acuerdo a la prelación de recuperación del mismo.</li>
        </ol>
    </div>
    <div>
     <?php $modality = $loan->modality;
        if(($modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo SENASIR')){ ?>
        <b>NOVENA.- (DE LA GARANTÍA):</b>El PRESTATARIO y GARANTE, garantizan el pago de lo adeudado con todos sus bienes, derechos y acciones habidos y por haber, presentes y futuros conforme lo determina el artículo 1335 del Código Civil asimismo el PRESTATARIO garantizá con su renta de vejez en curso de pago y además con el beneficio del Complemento Económico que otorga la MUSERPOL y el GARANTE garantiza con los beneficios que otorga la MUSERPOL, que son Fondo de Retiro Policial Solidario y Complemento Económico de acuerdo al Reglamento de Préstamos, en caso de corresponderle.<br> Se {{ count($guarantors) > 1 ? 'constituyen como garantes personales, solidarios, mancomunados, e indivisibles' : 'constituye como garante personal, solidario, mancomunado e indivisible' }}:
        <?php } else{
        if($modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo AFP'){ ?>
        <b>NOVENA.- (DE LA GARANTÍA):</b>El PRESTATARIO y GARANTE, garantizan el pago de lo adeudado con todos sus bienes, derechos y acciones habidos y por haber, presentes y futuros conforme lo determina el artículo 1335 del Código Civil, asimismo el PRESTATARIO garantiza con el Beneficio del Complemento Económico que otorga la MUSERPOL y el GARANTE garantiza con los beneficios que otorga la MUSERPOL que son Fondo de Retiro Policial Solidario y Complemento Económico deacuerdo al Reglamento de Préstamos de la MUSERPOL.<br> Asimismo se {{ count($guarantors) > 1 ? 'constituyen como garantes personales, solidarios, mancomunados, e indivisibles' : 'constituye como garante personal, solidario, mancomunado e indivisible' }}:
        <?php }
        if($modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Activo' || $modality->name == 'Refinanciamiento de Préstamo a largo Plazo con un Solo Garante Sector Activo CPOP'){ ?>
        <b>NOVENA.- (DE LA GARANTÍA):</b>El PRESTATARIO y GARANTE, garantizan el pago de lo adeudado con todos sus bienes, derechos y acciones habidos y por haber, presentes y futuros conforme lo determina el artículo 1335 del Código Civil y además con los beneficios del Fondo de Retiro Policial Solidario y Complemento Económico así como establece el artículo 65 del Reglamento de Préstamos de la MUSERPOL.<br> Asimismo se {{ count($guarantors) > 1 ? 'constituyen como garantes personales, solidarios, mancomunados, e indivisibles' : 'constituye como garante personal, solidario, mancomunado e indivisible' }}:
        <?php }?>
        <?php } ?>
        <?php $cont = 0; $concat_guarantor = "";
            foreach($guarantors as $guarantor){
                $male_female_guarantor = Util::male_female($guarantor->gender);
                $cont ++; $concat_guarantor = "(garante Nº ".$cont.")";

            ?>
            <span>
            {{ $guarantor->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $guarantor->full_name }}, con C.I. {{ $guarantor->identity_card_ext }}, {{ $guarantor->civil_status_gender }}, mayor de edad, hábil por derecho, natural de {{ $guarantor->city_birth->name }}, vecin{{ $male_female_guarantor }} de {{ $guarantor->address->cityName() }} y con domicilio especial en {{ $guarantor->address->full_address }}{{ count($guarantors) > 1 ? $concat_guarantor : '' }},
            </span>
        <?php } ?>
        <?php $modality = $loan->modality;
        if(($modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo SENASIR')){ ?>
         {{ count($guarantors) > 1 ? 'quienes garantizan' : 'quien garantiza' }} el cumplimiento de la obligación en caso que el PRESTATARIO, incumpliera con el pago de sus obligaciones o se constituyera en mora al incumplimiento de una o más cuotas de amortización, {{ count($guarantors) > 1 ? 'autorizan' : 'autoriza' }} el descuento mensual de su renta en curso de vejez y/o haberes en calidad de {{ count($guarantors) > 1 ? 'GARANTES' : 'GARANTE' }} bajo las mismas condiciones en las que se procedería a descontar al PRESTATARIO pasado los 2 meses sin necesidad de previo aviso incluidos los intereses penales, hasta cubrir el pago total de la obligación pendiente de cumplimiento. Excluyendo a la MUSERPOL de toda responsabilidad o reclamo posterior, sin perjuicio de que {{ count($guarantors) > 1 ? 'estos puedan' : 'este pueda' }}  iniciar las acciones legales correspondientes en contra del PRESTATARIO.
        <?php } else{
        if($modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Activo' || $modality->name == 'Refinanciamiento de Préstamo a largo Plazo con un Solo Garante Sector Activo CPOP'){ ?>
         {{ count($guarantors) > 1 ? 'quienes' : 'quien' }} {{$is_active? 'en amparo del artículo 64 y 65 del Reglamento de Préstamos de la MUSERPOL':''}} {{ count($guarantors) > 1 ? 'garantizaran' : 'garantiza' }} el cumplimiento de la obligación en caso que el PRESTATARIO, incumpliera con el pago de sus obligaciones o se constituyera en mora al incumplimiento de una o más cuotas de amortización, {{ count($guarantors) > 1 ? 'autorizan el descuento mensual de sus haberes' : 'autoriza el descuento mensual de sus haberes' }} en calidad de {{ count($guarantors) > 1 ? 'GARANTES' : 'GARANTE' }} bajo las mismas condiciones en las que se procedería a descontar al PRESTATARIO, hasta cubrir el pago total de la obligación pendiente de cumplimiento. Excluyendo a la MUSERPOL de toda responsabilidad o reclamo posterior, sin perjuicio de que {{ count($guarantors) > 1 ? 'estos puedan' : 'este pueda' }} iniciar las acciones legales correspondientes en contra del PRESTATARIO.
        <?php }
        if($modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo AFP'){ ?>
         {{ count($guarantors) > 1 ? 'quienes' : 'quien' }} {{$is_active? 'en amparo del artículo 64 y 65 del Reglamento de Préstamos de la MUSERPOL':''}} {{ count($guarantors) > 1 ? 'garantizaran' : 'garantiza' }} el cumplimiento de la obligación en caso que el PRESTATARIO, incumpliera con el pago de sus obligaciones o se constituyera en mora al incumplimiento de una o más cuotas de amortización, {{ count($guarantors) > 1 ? 'autorizan el descuento mensual de sus haberes' : 'autoriza el descuento mensual de sus haberes' }} en calidad de {{ count($guarantors) > 1 ? 'GARANTES' : 'GARANTE' }}, hasta cubrir el pago total de la obligación pendiente de cumplimiento. Excluyendo a la MUSERPOL de toda responsabilidad o reclamo posterior, sin perjuicio de que {{ count($guarantors) > 1 ? 'estos puedan' : 'este pueda' }} iniciar las acciones legales correspondientes en contra del PRESTATARIO.
        <?php }?>
        <?php } ?>
    </div>
    <div>
    <?php
        if($modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo AFP'||$modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo SENASIR'){ ?>
        <div>
            <b>DÉCIMA.- (CONTINGENCIAS POR FALLECIMIENTO/RETIRO):</b>El PRESTATARIO en caso de fallecimiento garantiza el cumplimiento efectivo de la presente obligación con el beneficio del Complemento Económico y Auxilio Mortuorio; por cuanto la liquidación de dichos beneficios pasarán a cubrir el monto total de la obligación que resulte adeudada, más los intereses devengados a la fecha, cobrados a los derechohabientes, previas las formalidades de ley. 
        </div>
        <div>
            Asimismo, el GARANTE en caso de fallecimiento, retiro voluntario o retiro forzoso garantiza con los beneficios de Fondo de Retiro Policial Solidario y Complemento Económico otorgados por la MUSERPOL, por cuanto la liquidación de dichos beneficios pasarán a cubrir el monto total de la obligación que resulte adeudada, más los intereses devengados a la fecha, previas las formalidades de ley. Toda vez que el Garante se constituye en la primera fuente de Repago del Préstamo.
        </div>
        <?php }
            else{
                if($modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Activo' || $modality->name == 'Refinanciamiento de Préstamo a largo Plazo con un Solo Garante Sector Activo CPOP'){ ?>
                 <div>
                    <b>DECIMA.- (MODIFICACIÓN DE LA SITUACIÓN DEL PRESTATARIO):</b> El PRESTATARIO y/o GARANTE en caso de fallecimiento, retiro voluntario o retiro forzoso garantizan con la totalidad de los Beneficios de Fondo de Retiro Policial Solidario y Complemento Económico otorgados por la MUSERPOL, el cumplimiento efectivo de la presente obligación; por cuanto la liquidación de dichos beneficios pasarán a cubrir el monto total de la obligación que resulte adeudada, más los intereses devengados a la fecha, previas las formalidades de ley.
                </div>
                <div>
                    En caso de que se haya modificado la situación del PRESTATARIO y/o GARANTE del sector activo al sector pasivo de la Policía Boliviana teniendo un saldo deudor respecto del préstamo obtenido, este acepta amortizar la deuda con su complemento económico, en caso de corresponderle debiendo al efecto solicitar la reprogramación conforme establece el artículo 90 del Reglamento de Préstamos de la MUSERPOL, por lo que el saldo se sujetará en función a su nuevo liquido pagable, estableciéndose una correlativa modificación de los plazos y cuota según sea el caso.
                </div>
                <div>
                    Asimismo, en caso de que el monto de sus beneficios del PRESTATARIO, no alcanzare a cubrir el total del monto adeudado, se descontará a los GARANTES el saldo deudor que quedare pendiente.
                </div>
                <?php }?>
        <?php   } ?>
    </div>
    <div>
        <b>DÉCIMA PRIMERA.- (DE LA MORA):</b> El PRESTATARIO se constituirá en mora automática sin intimación o requerimiento alguno, de acuerdo a lo establecido por el artículo 341, Núm. 1) del Código Civil, al incumplimiento del pago de cualquier amortización, sin necesidad de intimación o requerimiento alguno, o acto equivalente por parte de la MUSERPOL. 
    </div>
    <div>
    En caso de que el PRESTATARIO incurra en mora, se le añadirá al total de la obligación adeudada, un interés moratorio anual del {{ round($loan->interest->penal_interest) }}%, que será efectiva por todo el tiempo que perdure el incumplimiento objeto de la mora, debiendo ser cobrados de acuerdo a la disponibilidad de saldo deudor y/o requerimiento de la MUSERPOL.
    </div>
    <div>
        <b>DÉCIMA SEGUNDA.- (DE LOS EFECTOS DEL INCUMPLIMIENTO Y DE LA ACCIÓN EJECUTIVA):</b> El incumplimiento de pago mensual por parte del PRESTATARIO, dará lugar a que la totalidad de la obligación, incluidos los intereses moratorios, se determinen líquidos, exigibles y de plazo vencido quedando la MUSERPOL facultada de iniciar las acciones legales correspondientes al amparo de los artículos 519 y 1465 del Código Civil así como de los artículos 378 y 379, Núm. 2) del Código Procesal Civil, que otorgan a este documento la calidad de Título Ejecutivo, demandando el pago de la totalidad de la obligación contraída, más la cancelación de intereses convencionales y penales, daños y perjuicios así como la reparación de las costas procesales y honorarios profesionales que se generen por efecto de la acción legal que MUSERPOL instaure para lograr el cumplimiento total de la obligación.
    </div>
    <?php $modality = $loan->modality;
        if($modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Activo' || $modality->name == 'Refinanciamiento de Préstamo a largo Plazo con un Solo Garante Sector Activo CPOP'){ ?>
          <div>
          {{ count($guarantors) > 1 ? 'Los GARANTES están facultados' : 'El GARANTE esta facultado' }} a realizar el trámite de recuperación de los montos que se le hubieran sido descontados en función a la obligación objeto del presente contrato pudiendo recaer sobre él Beneficio de Fondo de Retiro Policial Solidario otorgados por la MUSERPOL y reconocidos al PRESTATARIO, conforme al artículo 127 del Reglamento de Préstamos.
        </div>
        <?php } ?>
    <div>
        En caso de incumplimiento de los pagos mensuales estipulados en el presente contrato que generen mora de la obligación, el PRESTATARIO no tendrá derecho a acceder a otro crédito, hasta la cancelación total de la deuda.
    </div>
    <div>
        <b>DÉCIMA TERCERA.- (DE LA CONFORMIDAD Y ACEPTACIÓN):</b> Por una parte en calidad de ACREEDOR la MUSERPOL, representada por su {{ $employees[0]['position'] }} {{ $employees[0]['name'] }} y su {{ $employees[1]['position'] }} {{ $employees[1]['name'] }} y por otra parte en calidad de
        @if (count($lenders) == 1)
        <span>DEUDOR{{ $lender->gender == 'M' ? '' : 'A' }} {{ $lender->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $lender->full_name }} de generales ya señaladas como PRESTATARIO; </span>
        <?php foreach($guarantors as $guarantor){ ?>
            <span>
            {{ $guarantor->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $guarantor->full_name }},
            </span>
        <?php } ?>
            {{ count($guarantors) > 1 ? 'ambos' : '' }} en su calidad de {{ count($guarantors) > 1 ? 'garantes personales, solidarios, mancomunados, e indivisibles' : 'garante personal, solidario, mancomunado e indivisible' }} también de generales ya conocidas;
            damos nuestra plena conformidad con todas y cada una de las cláusulas precedentes, obligándolos a su fiel y estricto cumplimiento. En señal de lo cual suscribimos el presente contrato de refinancimiento de préstamo de dinero en manifestación de nuestra libre y espontánea voluntad y sin que medie vicio de consentimiento alguno.
        </span>
        @endif
    </div><br><br>
    <div class="text-center">
        <p class="center">
        La Paz, {{ Carbon::now()->isoFormat('LL') }}
        </p>
    </div>
</div>
<div>
    <div>
        @if (count($guarantors) == 1)
        @php ($guarantor = $guarantors[0])
        <table>
            <tr>
                <td  with = "50%">
                @include('partials.signature_box', [
                    'full_name' => $lender->full_name,
                    'identity_card' => $lender->identity_card_ext,
                    'position' => 'PRESTATARIO'
                ])
                </td>
                <td  with = "50%">
                @include('partials.signature_box', [
                    'full_name' => $guarantor->full_name,
                    'identity_card' => $guarantor->identity_card_ext,
                    'position' => 'GARANTE'
                ])
                </td>
            </tr>
        </table>
        @endif
    </div>
    @if (count($guarantors) == 2)
    <div>
        @include('partials.signature_box', [
            'full_name' => $lender->full_name,
            'identity_card' => $lender->identity_card_ext,
            'position' => 'PRESTATARIO'
        ])
    </div>
    <div class = "no-page-break">
        <div>
            <table>
                <tr>
                    @foreach ($guarantors as $guarantor)
                    <td with = "50%">
                        @include('partials.signature_box', [
                            'full_name' => $guarantor->full_name,
                            'identity_card' => $guarantor->identity_card_ext,
                            'position' => 'GARANTE'
                        ])
                    @endforeach
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @endif
    <div>
        <table>
            <tr>
                @foreach ($employees as $key => $employee)
                <td width="50%">
                    @include('partials.signature_box', [
                        'full_name' => $employee['name'],
                        'identity_card' => $employee['identity_card'],
                        'position' => $employee['position'],
                        'employee' => true
                    ])
                @endforeach
                </td>
            </tr>
        </table>
    </div>
</div>
<?php }else{?>
<div class="block text-justify">
    <div>
        Conste en el presente contrato de préstamo de {{ $title }}, que al solo reconocimiento de firmas y rúbricas ante autoridad competente será elevado a Instrumento Público, por lo que las partes que intervienen lo suscriben al tenor de las siguientes cláusulas y condiciones:
    </div>
    <div>
        <b>PRIMERA.- (DE LAS PARTES):</b> Intervienen en el presente contrato, por una parte como ACREEDOR la Mutual de Servicios al Policía (MUSERPOL), representada legalmente por su {{ $employees[0]['position'] }} {{ $employees[0]['name'] }} con C.I. {{ $employees[0]['identity_card'] }} y su {{ $employees[1]['position'] }} {{ $employees[1]['name'] }} con C.I. {{ $employees[1]['identity_card'] }}, que para fines de este contrato en adelante se denominará MUSERPOL con domicilio en la Z. Sopocachi, Av. 6 de Agosto Nº 2354 y por otra parte como

        @if (count($lenders) == 1)
        @php ($lender = $lenders[0]->disbursable)
        @php ($male_female = Util::male_female($lender->gender))
        <span>
            DEUDOR{{ $lender->gender == 'M' ? '' : 'A' }} {{ $lender->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $lender->full_name }}, con C.I. {{ $lender->identity_card_ext }}, {{ $lender->civil_status_gender }}, mayor de edad, hábil por derecho, natural de {{ $lender->city_birth->name }}, vecin{{ $male_female }} de {{ $lender->address->cityName() }} y con domicilio especial en {{ $lender->address->full_address }}, en adelante denominad{{ $male_female }} PRESTATARIO.
        </span>
        @endif
    </div>
    <div>
        <b>SEGUNDA.- (DEL OBJETO):</b>  El objeto del presente contrato es el préstamo de dinero que MUSERPOL otorga al PRESTATARIO conforme a niveles de aprobación respectivos, en la suma de Bs.{{ Util::money_format($loan->amount_approved) }} (<span class="uppercase">{{ Util::money_format($loan->amount_approved, true) }} Bolivianos</span>).
    </div>
    <div>
        <b>TERCERA.- (DEL INTERÉS):</b> El préstamo objeto del presente contrato, devengará un interés ordinario del {{ $loan->interest->annual_interest }}%, anual sobre saldo deudor, el mismo que se recargará con el interés penal en caso de mora de una o más amortizaciones. Esta tasa de interés podrá ser modificada en cualquier momento de acuerdo a las condiciones financieras que adopte la MUSERPOL.
    </div>
    <div>
        <b>CUARTA.- (DEL DESEMBOLSO, DEL PLAZO Y LA CUOTA DE AMORTIZACIÓN):</b> El desembolso del préstamo se acredita mediante comprobante escrito en el que conste el abono efectuado a favor del PRESTATARIO, o a través de una cuenta bancaria del Banco Unión a solicitud del PRESTATARIO; reconociendo ambas partes que al amparo de este procedimiento se cumple satisfactoriamente la exigencia contenida en el artículo 1331 del Código de Comercio. El plazo fijo e improrrogable para el cumplimiento de la obligación contraída por el PRESTATARIO en virtud al préstamo otorgado es de {{ $loan->loan_term }} meses computables a partir de la fecha de desembolso. La cuota de amortización mensual es de Bs.{{ Util::money_format($loan->estimated_quota) }} (<span class="uppercase">{{ Util::money_format($loan->estimated_quota, true) }} Bolivianos</span>).
    </div>
    <div>
        Los intereses generados entre la fecha del desembolso del préstamo y la fecha del primer pago serán cobrados con la primera cuota; conforme los establece el Reglamento de Préstamos.
    </div>
    <div>
    <?php $modality = $loan->modality;
            if(($modality->name == 'Largo Plazo con Garantía Personal Sector Pasivo AFP')){ ?>
        <b>QUINTA.- (DE LA FORMA DE PAGO Y OTRAS CONTINGENCIAS):</b> Para el cumplimiento estricto de la obligación (capital e intereses) el PRESTATARIO, se obliga a cumplir con la cuota de amortización en forma mensual mediante pago directo en la oficina central de la MUSERPOL de la ciudad de La Paz o efectuar el depósito en la cuenta bancaria de la MUSERPOL y enviar la boleta de depósito original a la oficina central inmediatamente; caso contrario el PRESTATARIO se hará pasible al recargo correspondiente a los intereses que se generen al día de pago por la deuda contraída y consiguientemente se procederá al descuento al garante personal incluido los intereses penales pasando los dos meses sin necesidad de previo aviso.
        <?php }
        else{
            if($modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Activo' || $modality->name=='Largo Plazo con Garantía Personal Sector Activo' || $modality->name=='Refinanciamiento de Préstamo a largo Plazo con un Solo Garante Sector Activo CPOP' || $modality->name == 'Largo Plazo con un Solo Garante Sector Activo CPOP' ){
                $quinta = 'Comando General de la Policía Boliviana';
            }
            if($modality->name == 'Largo Plazo con Garantía Personal Sector Pasivo SENASIR' || $modality->name == 'Refinanciamiento de Préstamo a Largo Plazo Sector Pasivo SENASIR'){
                $quinta = 'Servicio Nacional del Sistema de Reparto SENASIR';
            }?>
        <b>QUINTA.- (DE LA FORMA DE PAGO Y OTRAS CONTINGENCIAS):</b> Para el cumplimiento estricto de la obligación (capital e intereses) el PRESTATARIO, autoriza expresamente a MUSERPOL practicar los descuentos respectivos de las rentas que percibe en forma mensual a través del {{ $quinta }} conforme al Reglamento de Préstamos.
        <div>
        Si por cualquier motivo la MUSERPOL estuviera imposibilitada de realizar el descuento por el medio señalado, el PRESTATARIO se obliga a cumplir con la cuota de amortización mediante pago directo en la Oficina Central de la MUSERPOL de la ciudad de La Paz o efectuar el depósito en la cuenta bancaria de la MUSERPOL y enviar la boleta de depósito original a la Oficina Central inmediatamente. <br>Caso contrario el PRESTATARIO se hará pasible al recargo correspondiente a los intereses que se generen al día de pago por la deuda contraída.
        </div>
        <div>
            Asimismo, el PRESTATARIO se compromete a hacer conocer oportunamente a MUSERPOL sobre la omisión del descuento mensual que se hubiera dado a efectos de solicitar al {{ $quinta }} se regularice este descuento, sin perjuicio que realice el depósito directo del mes omitido, de acuerdo a lo estipulado en el párrafo precedente. Caso contrario se procedera al descuento {{ count($guarantors) > 1 ? 'de los garantes personales' : 'del garante personal' }} incluido los intereses penales pasados los dos meses de incumplimiento, sin necesidad de previo aviso.
        </div>
        <?php }?>
    </div>
    <div>
        <b>SEXTA.- (DERECHOS DEL PRESTATARIO):</b> Conforme al artículo 29 del Reglamento de Préstamos las partes reconocen expresamente como derechos irrenunciables del PRESTATARIO, lo siguiente:
    </div>
    <div>
        <ol type="a">
            <li>Recibir buena atención, trato equitativo y digno por parte de los funcionarios de la MUSERPOL sin discriminación de ninguna naturaleza y/o por razones de edad, género, raza, religión o identidad cultural, con la debida diligencia según normativa legal vigente y las disposiciones internas de la entidad.</li>
            <li>A recibir los servicios prestados por la MUSERPOL en condiciones de calidez, calidad, oportunidad y disponibilidad, adecuadas a sus intereses económicos.</li>
            <li>A recibir por parte de la MUSERPOL, a través de sus funcionarios, información y orientación precisa en relación a: requisitos, características y condiciones del préstamo; que debe ser fidedigna, amplia, íntegra, clara, comprensible, oportuna y accesible; en caso de duda el afiliado podrá efectuar consultas, peticiones y solicitudes inherentes a los términos y condiciones contractuales del crédito, su situación financiera y legal emergente del mismo.</li>
            <li>A la confidencialidad, en el marco estricto de la normativa legal vigente y reclamar si el servicio recibido no se ajusta a lo previsto en la presente cláusula.</li>
            <li>Otros derechos reconocidos por disposiciones legales y/o reglamentarias, que no sean limitativos ni excluyentes.</li>
        </ol>
    </div>
    <div>
        <b>SÉPTIMA.- (OBLIGACIONES DEL PRESTATARIO):</b> Conforme al artículo 30 del Reglamento de Préstamos, las partes reconocen expresamente como obligaciones del PRESTATARIO, lo siguiente:
    </div>
    <div>
        <ol type="a">
            <li>Proporcionar a los funcionarios de la MUSERPOL, documentos legítimos, nítidos y legibles para la correcta tramitación de los mismos.</li>
            <li>Presentar documentos idóneos de todos los involucrados en el Préstamo solicitado.</li>
            <li>Cumplir con todos y cada uno de los artículos establecidos en el presente Reglamento de Préstamos.</li>
            <li>Cumplir con los requisitos, condiciones y lineamientos de préstamo.</li>
            <li>Cumplir con el Contrato de Préstamo suscrito entre la MUSERPOL y el PRESTATARIO.</li>
            <li>Amortizar mensualmente la deuda contraída con la MUSERPOL, hasta cubrir el capital adeudado.</li>
            <li>Presentar toda documentación en los plazos previstos por el reglamento.</li>
            <li>Honrar toda deuda pendiente con la MUSERPOL (no estar en mora, al momento de solicitar un nuevo préstamo y/o servicio).</li>
            <li>El deudor debe comunicar a la MUSERPOL, de forma escrita cualquier situación o contingencia. Incluso el cambio de domicilio.</li>
            <li>En el caso de los Garantes, los mismos se constituyen en la primera fuente de Repago del Préstamo, de acuerdo a la prelación de recuperación del mismo.</li>
        </ol>
    </div>
    <div>
     <?php $modality = $loan->modality;
        if(($modality->name == 'Largo Plazo con Garantía Personal Sector Pasivo SENASIR')){ ?>
        <b>OCTAVA.- (DE LA GARANTÍA):</b>El PRESTATARIO y GARANTE, garantizan el pago de lo adeudado con todos sus bienes, derechos y acciones habidos y por haber, presentes y futuros conforme lo determina el artículo 1335 del Código Civil asimismo el PRESTATARIO garantizá con su renta de vejez en curso de pago y además con el beneficio del Complemento Económico que otorga la MUSERPOL y el GARANTE, garantiza con los beneficios que otorga la MUSERPOL que son Fondo de Retiro Policial Solidario y Complemento Económico de acuerdo al Reglamento de Préstamos, (en caso de corresponderle).<br> Se {{ count($guarantors) > 1 ? 'constituyen como garantes personales, solidarios, mancomunados, e indivisibles' : 'constituye como garante personal, solidario, mancomunado e indivisible' }}:
        <?php } else{
        if($modality->name == 'Largo Plazo con Garantía Personal Sector Pasivo AFP'){ ?>
        <b>OCTAVA.- (DE LA GARANTÍA):</b>El PRESTATARIO y GARANTE, garantizan el pago de lo adeudado con todos sus bienes, derechos y acciones habidos y por haber, presentes y futuros conforme lo determina el artículo 1335 del Código Civil, asimismo el PRESTATRIO, garantiza con el Beneficio de Complemento Económico que otorga la MUSERPOL y el GARANTE, garantiza con los beneficios que otorga la MUSERPOL que son Fondo de Retio Policial Solidario y Complemento Económico de acuerdo al Reglamento de Préstamos de la MUSERPOL.<br> Se {{ count($guarantors) > 1 ? 'constituyen como garantes personales, solidarios, mancomunados, e indivisibles' : 'constituye como garante personal, solidario, mancomunado e indivisible' }}:
        <?php }
        if($modality->name == 'Largo Plazo con Garantía Personal Sector Activo'||$modality->name == 'Largo Plazo con un Solo Garante Sector Activo CPOP'){ ?>
        <b>OCTAVA.- (DE LA GARANTÍA):</b>El PRESTATARIO y GARANTE, garantizan el pago de lo adeudado con todos sus bienes, derechos y acciones habidos y por haber, presentes y futuros conforme lo determina el artículo 1335 del Código Civil y además con los beneficios del Fondo de Retiro Policial Solidario y Complemento Económico así como establece el artículo 65 del Reglamento de Préstamos de la MUSERPOL.<br> Asimismo se {{ count($guarantors) > 1 ? 'constituyen como garantes personales, solidarios, mancomunados, e indivisibles' : 'constituye como garante personal, solidario, mancomunado e indivisible' }}:
        <?php }?>
        <?php } ?>
        <?php $cont = 0; $concat_guarantor = "";
            foreach($guarantors as $guarantor){
                $male_female_guarantor = Util::male_female($guarantor->gender);
                $cont ++; $concat_guarantor = "(garante Nº ".$cont.")";

            ?>
            <span>
            {{ $guarantor->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $guarantor->full_name }}, con C.I. {{ $guarantor->identity_card_ext }}, {{ $guarantor->civil_status_gender }}, mayor de edad, hábil por derecho, natural de {{ $guarantor->city_birth->name }}, vecin{{ $male_female_guarantor }} de {{ $guarantor->address->cityName() }} y con domicilio especial en {{ $guarantor->address->full_address }}{{ count($guarantors) > 1 ? $concat_guarantor : '' }},
            </span>
        <?php } ?>
        <?php $modality = $loan->modality;
        if(($modality->name == 'Largo Plazo con Garantía Personal Sector Pasivo SENASIR')){ ?>
         {{ count($guarantors) > 1 ? 'quienes garantizan' : 'quien garantiza' }} el cumplimiento de la obligación en caso que el PRESTATARIO, incumpliera con el pago de sus obligaciones o se constituyera en mora al incumplimiento de una o más cuotas de amortización, {{ count($guarantors) > 1 ? 'autorizan' : 'autoriza' }} el descuento mensual de su renta en curso de vejez y/o haberes en calidad de {{ count($guarantors) > 1 ? 'GARANTES' : 'GARANTE' }} bajo las mismas condiciones en las que se procedería a descontar al PRESTATARIO, hasta cubrir el pago total de la obligación pendiente de cumplimiento. Excluyendo a la MUSERPOL de toda responsabilidad o reclamo posterior, sin perjuicio de que {{ count($guarantors) > 1 ? 'estos puedan' : 'este pueda' }}  iniciar las acciones legales correspondientes en contra del PRESTATARIO.
        <?php } else{
        if($modality->name == 'Largo Plazo con Garantía Personal Sector Activo' || $modality->name == 'Largo Plazo con un Solo Garante Sector Activo CPOP'){ ?>
         {{ count($guarantors) > 1 ? 'quienes' : 'quien' }} {{$is_active? 'en amparo del artículo 64 y 65 del Reglamento de Préstamos de la MUSERPOL':''}} {{ count($guarantors) > 1 ? 'garantizaran' : 'garantiza' }} el cumplimiento de la obligación en caso que el PRESTATARIO, incumpliera con el pago de sus obligaciones o se constituyera en mora al incumplimiento de una o más cuotas de amortización, {{ count($guarantors) > 1 ? 'autorizan el descuento mensual de sus haberes' : 'autoriza el descuento mensual de sus haberes' }} en calidad de {{ count($guarantors) > 1 ? 'GARANTES' : 'GARANTE' }} bajo las mismas condiciones en las que se procedería a descontar al PRESTATARIO, hasta cubrir el pago total de la obligación pendiente de cumplimiento. Excluyendo a la MUSERPOL de toda responsabilidad o reclamo posterior, sin perjuicio de que {{ count($guarantors) > 1 ? 'estos puedan' : 'este pueda' }} iniciar las acciones legales correspondientes en contra del PRESTATARIO.
        <?php }
         if($modality->name == 'Largo Plazo con Garantía Personal Sector Pasivo AFP'){ ?>
            {{ count($guarantors) > 1 ? 'quienes' : 'quien' }} {{$is_active? 'en amparo del artículo 64 y 65 del Reglamento de Préstamos de la MUSERPOL':''}} {{ count($guarantors) > 1 ? 'garantizaran' : 'garantiza' }} el cumplimiento de la obligación en caso que el PRESTATARIO, incumpliera con el pago de sus obligaciones o se constituyera en mora al incumplimiento de una o más cuotas de amortización, {{ count($guarantors) > 1 ? 'autorizan el descuento mensual de sus haberes' : 'autoriza el descuento mensual de sus haberes' }} en calidad de {{ count($guarantors) > 1 ? 'GARANTES' : 'GARANTE' }}, hasta cubrir el pago total de la obligación pendiente de cumplimiento. Excluyendo a la MUSERPOL de toda responsabilidad o reclamo posterior, sin perjuicio de que estos puedadn iniciar las acciones legales correspondientes en contra del PRESTATARIO.
           <?php }?>
        <?php } ?>
    </div>
    <div>
    <?php
        if($modality->name == 'Largo Plazo con Garantía Personal Sector Pasivo AFP'||$modality->name == 'Largo Plazo con Garantía Personal Sector Pasivo SENASIR'){ ?>
        <div>
            <b>NOVENA.- (CONTINGENCIAS POR FALLECIMIENTO/RETIRO):</b>El PRESTATARIO en caso de fallecimiento garantiza el cumplimiento efectivo de la presente obligación con el beneficio del Complemento Económico y Auxilio Mortuorio; por cuanto la liquidación de dichos beneficios pasarán a cubrir el monto total de la obligación que resulte adeudada, más los intereses devengados a la fecha, cobrados a los derechohabientes, previas las formalidades de ley. 
        </div>
        <div>
            Asimismo, el GARANTE en caso de fallecimiento, retiro voluntario o retiro forzoso garantiza con los beneficios de Fondo de Retiro Policial Solidario y Complemento Económico otorgados por la MUSERPOL, por cuanto la liquidación de dichos beneficios pasarán a cubrir el monto total de la obligación que resulte adeudada, más los intereses devengados a la fecha, previas las formalidades de ley. Toda vez que el Garante se constituye en la primera fuente de Repago del Préstamo.
        </div>
        <?php }
            else{
                if($modality->name == 'Largo Plazo con Garantía Personal Sector Activo' || $modality->name == 'Largo Plazo con un Solo Garante Sector Activo CPOP'){ ?>
                 <div>
                    <b>NOVENA.- (MODIFICACIÓN DE LA SITUACIÓN DEL PRESTATARIO):</b> El PRESTATARIO y/o GARANTE en caso de fallecimiento, retiro voluntario o retiro forzoso garantizan con la totalidad de los Beneficios de Fondo de Retiro Policial Solidario y Complemento Económico otorgados por la MUSERPOL, el cumplimiento efectivo de la presente obligación; por cuanto la liquidación de dichos beneficios pasarán a cubrir el monto total de la obligación que resulte adeudada, más los intereses devengados a la fecha, previas las formalidades de ley.
                </div>
                <div>
                    En caso de que se haya modificado la situación del PRESTATARIO y/o GARANTE del sector activo al sector pasivo de la Policía Boliviana teniendo un saldo deudor respecto del préstamo obtenido, este acepta amortizar la deuda con su complemento económico, en caso de corresponderle debiendo al efecto solicitar la reprogramación conforme establece el artículo 90 del Reglamento de Préstamos de la MUSERPOL, por lo que el saldo se sujetará en función a su nuevo liquido pagable, estableciéndose una correlativa modificación de los plazos y cuota según sea el caso.
                </div>
                <div>
                    Asimismo, en caso de que el monto de sus beneficios del PRESTATARIO, no alcanzare a cubrir el total del monto adeudado, se descontará a los GARANTES el saldo deudor que quedare pendiente.
                </div>
                <?php }?>
        <?php   } ?>
    </div>
    <div>
        <b>DÉCIMA.- (DE LA MORA):</b> El PRESTATARIO se constituirá en mora automática sin intimación o requerimiento alguno, de acuerdo a lo establecido por el artículo 341, Núm. 1) del Código Civil, al incumplimiento del pago de cualquier amortización, sin necesidad de intimación o requerimiento alguno, o acto equivalente por parte de la MUSERPOL.<br> En caso de que el PRESTATARIO incurra en mora, se le añadirá al total de la obligación adeudada, un interés moratorio anual del {{ round($loan->interest->penal_interest) }}%, que será efectiva por todo el tiempo que perdure el incumplimiento objeto de la mora, debiendo ser cobrados de acuerdo a la disponibilidad de saldo deudor y/o requerimiento de la MUSERPOL.
    </div>
    <div>
        <b>DÉCIMA PRIMERA.- (DE LOS EFECTOS DEL INCUMPLIMIENTO Y DE LA ACCIÓN EJECUTIVA):</b> El incumplimiento de pago mensual por parte del PRESTATARIO dará lugar a que la totalidad de la obligación, incluidos los intereses moratorios, se determinen líquidos, exigibles y de plazo vencido quedando la MUSERPOL facultada de iniciar las acciones legales correspondientes al amparo de los artículos 519 y 1465 del Código Civil así como de los artículos 378 y 379, Núm. 2) del Código Procesal Civil, que otorgan a este documento la calidad de Título Ejecutivo, demandando el pago de la totalidad de la obligación contraída, más la cancelación de intereses convencionales y penales, daños y perjuicios así como la reparación de las costas procesales y honorarios profesionales que se generen por efecto de la acción legal que MUSERPOL instaure para lograr el cumplimiento total de la obligación.
    </div>
    <?php $modality = $loan->modality;
        if($modality->name == 'Largo Plazo con Garantía Personal Sector Activo' || $modality->name == 'Largo Plazo con un Solo Garante Sector Activo CPOP'){ ?>
          <div>
          {{ count($guarantors) > 1 ? 'Los GARANTES están facultados' : 'El GARANTE esta facultado' }} a realizar el trámite de recuperación de los montos que se le hubieran sido descontados en función a la obligación objeto del presente contrato pudiendo recaer sobre él Beneficio de Fondo de Retiro Policial Solidario otorgados por la MUSERPOL y reconocidos al PRESTATARIO, conforme al artículo 127 del Reglamento de Préstamos.
        </div>
        <?php } ?>
    <div>
        En caso de incumplimiento de los pagos mensuales estipulados en el presente contrato que generen mora de la obligación, el PRESTATARIO no tendrá derecho a acceder a otro crédito, hasta la cancelación total de la deuda.
    </div>
    <div>
        <b>DÉCIMA SEGUNDA.- (DE LA CONFORMIDAD Y ACEPTACIÓN):</b> Por una parte en calidad de ACREEDOR la MUSERPOL, representada por su {{ $employees[0]['position'] }} {{ $employees[0]['name'] }} y su {{ $employees[1]['position'] }} {{ $employees[1]['name'] }} y por otra parte en calidad de
        @if (count($lenders) == 1)
        <span>DEUDOR{{ $lender->gender == 'M' ? '' : 'A' }} {{ $lender->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $lender->full_name }} de generales ya señaladas como PRESTATARIO; </span>
        <?php foreach($guarantors as $guarantor){ ?>
            <span>
            {{ $guarantor->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $guarantor->full_name }},
            </span>
        <?php } ?>
            {{ count($guarantors) > 1 ? 'ambos' : '' }} en su calidad de {{ count($guarantors) > 1 ? 'garantes personales, solidarios, mancomunados, e indivisibles' : 'garante personal, solidario, mancomunado e indivisible' }} también de generales ya conocidas;
            damos nuestra plena conformidad con todas y cada una de las cláusulas precedentes, obligándolos a su fiel y estricto cumplimiento. En señal de lo cual suscribimos el presente contrato de préstamo de dinero con garantía personal en manifestación de nuestra libre y espontánea voluntad y sin que medie vicio de consentimiento alguno.
        </span>
        @endif
    </div><br><br>
    <div class="text-center">
        <p class="center">
        La Paz, {{ Carbon::now()->isoFormat('LL') }}
        </p>
    </div>
</div>
<div>
    <div>
        @if (count($guarantors) == 1)
        @php ($guarantor = $guarantors[0])
        <table>
            <tr>
                <td  with = "50%">
                @include('partials.signature_box', [
                    'full_name' => $lender->full_name,
                    'identity_card' => $lender->identity_card_ext,
                    'position' => 'PRESTATARIO'
                ])
                </td>
                <td  with = "50%">
                @include('partials.signature_box', [
                    'full_name' => $guarantor->full_name,
                    'identity_card' => $guarantor->identity_card_ext,
                    'position' => 'GARANTE'
                ])
                </td>
            </tr>
        </table>
        @endif
    </div>
    @if (count($guarantors) == 2)
    <div>
        @include('partials.signature_box', [
            'full_name' => $lender->full_name,
            'identity_card' => $lender->identity_card_ext,
            'position' => 'PRESTATARIO'
        ])
    </div>
    <div class = "no-page-break">
        <div>
            <table>
                <tr>
                    @foreach ($guarantors as $guarantor)
                    <td with = "50%">
                        @include('partials.signature_box', [
                            'full_name' => $guarantor->full_name,
                            'identity_card' => $guarantor->identity_card_ext,
                            'position' => 'GARANTE'
                        ])
                    @endforeach
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @endif
    <div>
        <table>
            <tr>
                @foreach ($employees as $key => $employee)
                <td width="50%">
                    @include('partials.signature_box', [
                        'full_name' => $employee['name'],
                        'identity_card' => $employee['identity_card'],
                        'position' => $employee['position'],
                        'employee' => true
                    ])
                @endforeach
                </td>
            </tr>
        </table>
    </div>
</div>
<?php }?>
</body>
</html>
