<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Datenschutzerklärung</title>



    <script src="{{ asset('public/dashboard') }}/assets/js/config.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="{{ asset('public/dashboard') }}/vendors/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('public/dashboard') }}/vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link href="{{ asset('public/dashboard') }}/assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('public/dashboard') }}/assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="{{ asset('public/dashboard') }}/assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('public/dashboard') }}/assets/css/user.min.css" rel="stylesheet" id="user-style-default">
    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
</head>


<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">



        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="py-3 bg-light shadow-sm">

            <div class="container">
                <div class="row">
                    <div class="col-3 col-sm-auto my-1 my-sm-3 px-card"><a href="{{url('/home')}}"><img class="landing-cta-img" height="40"
                            src="{{ asset('public') }}/assets/logo-vertical.png" alt="" /></a>
                    </div>
                </div>
            </div>
            <!-- end of .container-->

        </section>
        <!-- <section> close ============================-->
        <!-- ============================================-->




        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-7 col-xxl-6">
                        <h1 class="fs-2 fs-sm-4 fs-md-5">Datenschutzerklärung</h1>
                    </div>
                </div>
                <div class="row flex-center mt-2">
                    <div class="col-md col-xxl-6 col-lg-8 col-xl-7 mt-4 mt-md-0">
                        <!-- wp:heading {"level":4} -->
                        <h4>Datenschutz auf einen Blick</h4>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Allgemeine Hinweise</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Die folgenden Hinweise geben einen einfachen Überblick darüber, was mit Ihren
                            personenbezogenen Daten passiert, wenn Sie unsere Website besuchen. Personenbezogene Daten
                            sind alle Daten, mit denen Sie persönlich identifiziert werden können. Ausführliche
                            Informationen zum Thema Datenschutz entnehmen Sie unserer unter diesem Text aufgeführten
                            Datenschutzerklärung.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Datenerfassung auf unserer Website</h5>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Wer ist verantwortlich für die Datenerfassung auf dieser Website?</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Die Datenverarbeitung auf dieser Website erfolgt durch den Websitebetreiber. Dessen
                            Kontaktdaten können Sie dem Impressum dieser Website entnehmen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Wie erfassen wir Ihre Daten?</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Ihre Daten werden zum einen dadurch erhoben, dass Sie uns diese mitteilen. Hierbei kann es
                            sich z. B. um Daten handeln, die Sie in ein Kontaktformular eingeben.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Andere Daten werden automatisch beim Besuch der Website durch unsere IT-Systeme erfasst. Das
                            sind vor allem technische Daten (z.&nbsp;B. Internetbrowser, Betriebssystem oder Uhrzeit des
                            Seitenaufrufs). Die Erfassung dieser Daten erfolgt automatisch, sobald Sie unsere Website
                            betreten.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Wofür nutzen wir Ihre Daten?</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Ein Teil der Daten wird erhoben, um eine fehlerfreie Bereitstellung der Website zu
                            gewährleisten. Andere Daten können zur Analyse Ihres Nutzerverhaltens verwendet werden.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Welche Rechte haben Sie bezüglich Ihrer Daten?</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Sie haben jederzeit das Recht unentgeltlich Auskunft über Herkunft, Empfänger und Zweck Ihrer
                            gespeicherten personenbezogenen Daten zu erhalten. Sie haben außerdem ein Recht, die
                            Berichtigung, Sperrung oder Löschung dieser Daten zu verlangen. Hierzu sowie zu weiteren
                            Fragen zum Thema Datenschutz können Sie sich jederzeit unter der im Impressum angegebenen
                            Adresse an uns wenden. Des Weiteren steht Ihnen ein Beschwerderecht bei der zuständigen
                            Aufsichtsbehörde zu.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Außerdem haben Sie das Recht, unter bestimmten Umständen die Einschränkung der Verarbeitung
                            Ihrer personenbezogenen Daten zu verlangen. Details hierzu entnehmen Sie der
                            Datenschutzerklärung unter „Recht auf Einschränkung der Verarbeitung“.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Analyse-Tools und Tools von Drittanbietern</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Beim Besuch unserer Website kann Ihr Surf-Verhalten statistisch ausgewertet werden. Das
                            geschieht vor allem mit Cookies und mit sogenannten Analyseprogrammen. Die Analyse Ihres
                            Surf-Verhaltens erfolgt in der Regel anonym; das Surf-Verhalten kann nicht zu Ihnen
                            zurückverfolgt werden.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sie können dieser Analyse widersprechen oder sie durch die Nichtbenutzung bestimmter Tools
                            verhindern. Detaillierte Informationen zu diesen Tools und über Ihre
                            Widerspruchsmöglichkeiten finden Sie in der folgenden Datenschutzerklärung.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":4} -->
                        <h4>Allgemeine Hinweise und Pflichtinformationen</h4>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Datenschutz</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Die Betreiber dieser Seiten nehmen den Schutz Ihrer persönlichen Daten sehr ernst. Wir
                            behandeln Ihre personenbezogenen Daten vertraulich und entsprechend der gesetzlichen
                            Datenschutzvorschriften sowie dieser Datenschutzerklärung. Wenn Sie diese Website benutzen,
                            werden verschiedene personenbezogene Daten erhoben. Personenbezogene Daten sind Daten, mit
                            denen Sie persönlich identifiziert werden können. Die vorliegende Datenschutzerklärung
                            erläutert, welche Daten wir erheben und wofür wir sie nutzen. Sie erläutert auch, wie und zu
                            welchem Zweck das geschieht. Wir weisen darauf hin, dass die Datenübertragung im Internet
                            (z.&nbsp;B. bei der Kommunikation per E-Mail) Sicherheitslücken aufweisen kann. Ein
                            lückenloser Schutz der Daten vor dem Zugriff durch Dritte ist nicht möglich.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Hinweis zur verantwortlichen Stelle</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Die verantwortliche Stelle für die Datenverarbeitung auf dieser Website ist:</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>SECRET<br>Telefon: 02732 70144<br>E-Mail:&nbsp;info@secretalign.com</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Verantwortliche Stelle ist die natürliche oder juristische Person, die allein oder gemeinsam
                            mit anderen über die Zwecke und Mittel der Verarbeitung von personenbezogenen Daten
                            (z.&nbsp;B. Namen, E-Mail-Adressen o. Ä.) entscheidet.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Widerruf Ihrer Einwilligung zur Datenverarbeitung</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Viele Datenverarbeitungsvorgänge sind nur mit Ihrer ausdrücklichen Einwilligung möglich. Sie
                            können eine bereits erteilte Einwilligung jederzeit widerrufen. Dazu reicht eine formlose
                            Mitteilung per E-Mail an uns. Die Rechtmäßigkeit der bis zum Widerruf erfolgten
                            Datenverarbeitung bleibt vom Widerruf unberührt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Widerspruchsrecht gegen die Datenerhebung in besonderen Fällen sowie gegen Direktwerbung
                            (Art. 21 DSGVO)</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p><strong>Wenn die Datenverarbeitung auf Grundlage von Art. 6 Abs. 1 lit. e oder f DSGVO
                                erfolgt, haben Sie jederzeit das Recht, aus Gründen, die sich aus Ihrer besonderen
                                Situation ergeben, gegen die Verarbeitung Ihrer personenbezogenen Daten Widerspruch
                                einzulegen; dies gilt auch für ein auf diese Bestimmungen gestütztes Profiling. Die
                                jeweilige Rechtsgrundlage, auf denen eine Verarbeitung beruht, entnehmen Sie dieser
                                Datenschutzerklärung. Wenn Sie Widerspruch einlegen, werden wir Ihre betroffenen
                                personenbezogenen Daten nicht mehr verarbeiten, es sei denn, wir können zwingende
                                schutzwürdige Gründe für die Verarbeitung nachweisen, die Ihre Interessen, Rechte und
                                Freiheiten überwiegen oder die Verarbeitung dient der Geltendmachung, Ausübung oder
                                Verteidigung von Rechtsansprüchen (Widerspruch nach Art. 21 Abs. 1 DSGVO).</strong></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><strong>Werden Ihre personenbezogenen Daten verarbeitet, um Direktwerbung zu betreiben, so
                                haben Sie das Recht, jederzeit Widerspruch gegen die Verarbeitung Sie betreffender
                                personenbezogener Daten zum Zwecke derartiger Werbung einzulegen; dies gilt auch für das
                                Profiling, soweit es mit solcher Direktwerbung in Verbindung steht. Wenn Sie
                                widersprechen, werden Ihre personenbezogenen Daten anschließend nicht mehr zum Zwecke
                                der Direktwerbung verwendet (Widerspruch nach Art. 21 Abs. 2 DSGVO).</strong></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Beschwerderecht bei der zuständigen Aufsichtsbehörde</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Im Falle von Verstößen gegen die DSGVO steht den Betroffenen ein Beschwerderecht bei einer
                            Aufsichtsbehörde, insbesondere in dem Mitgliedstaat ihres gewöhnlichen Aufenthalts, ihres
                            Arbeitsplatzes oder des Orts des mutmaßlichen Verstoßes zu. Das Beschwerderecht besteht
                            unbeschadet anderweitiger verwaltungsrechtlicher oder gerichtlicher Rechtsbehelfe. Eine
                            Liste der Datenschutzbeauftragten sowie deren Kontaktdaten können folgendem Link entnommen
                            werden:&nbsp;<a
                                href="https://www.bfdi.bund.de/DE/Service/Anschriften/anschriften_table.html"
                                target="_blank"
                                rel="noreferrer noopener">https://www.bfdi.bund.de/DE/Service/Anschriften/anschriften_table.html</a>&nbsp;(Deutschland)
                            und&nbsp;<a href="https://www.dsb.gv.at/ueber-die-website/kontakt.html" target="_blank"
                                rel="noreferrer noopener">https://www.dsb.gv.at/ueber-die-website/kontakt.html</a>&nbsp;(Österreich).
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Recht auf Datenübertragbarkeit</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Sie haben das Recht, Daten, die wir auf Grundlage Ihrer Einwilligung oder in Erfüllung eines
                            Vertrags automatisiert verarbeiten, an sich oder an einen Dritten in einem gängigen,
                            maschinenlesbaren Format aushändigen zu lassen. Sofern Sie die direkte Übertragung der Daten
                            an einen anderen Verantwortlichen verlangen, erfolgt dies nur, soweit es technisch machbar
                            ist.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>SSL- bzw. TLS-Verschlüsselung</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Diese Seite nutzt aus Sicherheitsgründen und zum Schutz der Übertragung vertraulicher
                            Inhalte, wie zum Beispiel Bestellungen oder Anfragen, die Sie an uns als Seitenbetreiber
                            senden, eine SSL- bzw. TLS-Verschlüsselung. Eine verschlüsselte Verbindung erkennen Sie
                            daran, dass die Adresszeile des Browsers von „http://“ auf „https://“ wechselt und an dem
                            Schloss-Symbol in Ihrer Browserzeile.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn die SSL- bzw. TLS-Verschlüsselung aktiviert ist, können die Daten, die Sie an uns
                            übermitteln, nicht von Dritten mitgelesen werden.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Verschlüsselter Zahlungsverkehr</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Besteht nach dem Abschluss eines kostenpflichtigen Vertrags eine Verpflichtung, uns Ihre
                            Zahlungsdaten (z.&nbsp;B. Kontonummer bei Einzugsermächtigung) zu übermitteln, werden diese
                            Daten zur Zahlungsabwicklung benötigt. Der Zahlungsverkehr über die gängigen Zahlungsmittel
                            (Visa/MasterCard, Lastschriftverfahren) erfolgt ausschließlich über eine verschlüsselte SSL-
                            bzw. TLS-Verbindung. Eine verschlüsselte Verbindung erkennen Sie daran, dass die Adresszeile
                            des Browsers von „http://“ auf „https://“ wechselt und an dem Schloss-Symbol in Ihrer
                            Browserzeile. Bei verschlüsselter Kommunikation können Ihre Zahlungsdaten, die Sie an uns
                            übermitteln, nicht von Dritten mitgelesen werden.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Auskunft, Sperrung, Löschung und Berichtigung</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Sie haben im Rahmen der geltenden gesetzlichen Bestimmungen jederzeit das Recht auf
                            unentgeltliche Auskunft über Ihre gespeicherten personenbezogenen Daten, deren Herkunft und
                            Empfänger und den Zweck der Datenverarbeitung und ggf. ein Recht auf Berichtigung, Sperrung
                            oder Löschung dieser Daten. Hierzu sowie zu weiteren Fragen zum Thema personenbezogene Daten
                            können Sie sich jederzeit unter der im Impressum angegebenen Adresse an uns wenden.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Recht auf Einschränkung der Verarbeitung</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Sie haben das Recht, die Einschränkung der Verarbeitung Ihrer personenbezogenen Daten zu
                            verlangen. Hierzu können Sie sich jederzeit unter der im Impressum angegebenen Adresse an
                            uns wenden. Das Recht auf Einschränkung der Verarbeitung besteht in folgenden Fällen:</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:list -->
                        <ul>
                            <!-- wp:list-item -->
                            <li>Wenn Sie die Richtigkeit Ihrer bei uns gespeicherten personenbezogenen Daten bestreiten,
                                benötigen wir in der Regel Zeit, um dies zu überprüfen. Für die Dauer der Prüfung haben
                                Sie das Recht, die Einschränkung der Verarbeitung Ihrer personenbezogenen Daten zu
                                verlangen.</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Wenn die Verarbeitung Ihrer personenbezogenen Daten unrechtmäßig geschah/geschieht,
                                können Sie statt der Löschung die Einschränkung der Datenverarbeitung verlangen.</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Wenn wir Ihre personenbezogenen Daten nicht mehr benötigen, Sie sie jedoch zur Ausübung,
                                Verteidigung oder Geltendmachung von Rechtsansprüchen benötigen, haben Sie das Recht,
                                statt der Löschung die Einschränkung der Verarbeitung Ihrer personenbezogenen Daten zu
                                verlangen.</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Wenn Sie einen Widerspruch nach Art. 21 Abs. 1 DSGVO eingelegt haben, muss eine Abwägung
                                zwischen Ihren und unseren Interessen vorgenommen werden. Solange noch nicht feststeht,
                                wessen Interessen überwiegen, haben Sie das Recht, die Einschränkung der Verarbeitung
                                Ihrer personenbezogenen Daten zu verlangen.</li>
                            <!-- /wp:list-item -->
                        </ul>
                        <!-- /wp:list -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie die Verarbeitung Ihrer personenbezogenen Daten eingeschränkt haben, dürfen diese
                            Daten – von ihrer Speicherung abgesehen – nur mit Ihrer Einwilligung oder zur
                            Geltendmachung, Ausübung oder Verteidigung von Rechtsansprüchen oder zum Schutz der Rechte
                            einer anderen natürlichen oder juristischen Person oder aus Gründen eines wichtigen
                            öffentlichen Interesses der Europäischen Union oder eines Mitgliedstaats verarbeitet werden.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Widerspruch gegen Werbe-Mails</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Der Nutzung von im Rahmen der Impressumspflicht veröffentlichten Kontaktdaten zur Übersendung
                            von nicht ausdrücklich angeforderter Werbung und Informationsmaterialien wird hiermit
                            widersprochen. Die Betreiber der Seiten behalten sich ausdrücklich rechtliche Schritte im
                            Falle der unverlangten Zusendung von Werbeinformationen, etwa durch Spam-E-Mails, vor.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":4} -->
                        <h4>Datenerfassung auf unserer Website</h4>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Cookies</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Die Internetseiten verwenden teilweise so genannte Cookies. Cookies richten auf Ihrem Rechner
                            keinen Schaden an und enthalten keine Viren. Cookies dienen dazu, unser Angebot
                            nutzerfreundlicher, effektiver und sicherer zu machen. Cookies sind kleine Textdateien, die
                            auf Ihrem Rechner abgelegt werden und die Ihr Browser speichert.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die meisten der von uns verwendeten Cookies sind so genannte „Session-Cookies“. Sie werden
                            nach Ende Ihres Besuchs automatisch gelöscht. Andere Cookies bleiben auf Ihrem Endgerät
                            gespeichert bis Sie diese löschen. Diese Cookies ermöglichen es uns, Ihren Browser beim
                            nächsten Besuch wiederzuerkennen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sie können Ihren Browser so einstellen, dass Sie über das Setzen von Cookies informiert
                            werden und Cookies nur im Einzelfall erlauben, die Annahme von Cookies für bestimmte Fälle
                            oder generell ausschließen sowie das automatische Löschen der Cookies beim Schließen des
                            Browser aktivieren. Bei der Deaktivierung von Cookies kann die Funktionalität dieser Website
                            eingeschränkt sein.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Cookies, die zur Durchführung des elektronischen Kommunikationsvorgangs oder zur
                            Bereitstellung bestimmter, von Ihnen erwünschter Funktionen (z.&nbsp;B. Warenkorbfunktion)
                            erforderlich sind, werden auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO gespeichert. Der
                            Websitebetreiber hat ein berechtigtes Interesse an der Speicherung von Cookies zur technisch
                            fehlerfreien und optimierten Bereitstellung seiner Dienste. Soweit andere Cookies
                            (z.&nbsp;B. Cookies zur Analyse Ihres Surfverhaltens) gespeichert werden, werden diese in
                            dieser Datenschutzerklärung gesondert behandelt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Server-Log-Dateien</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Der Provider der Seiten erhebt und speichert automatisch Informationen in so genannten
                            Server-Log-Dateien, die Ihr Browser automatisch an uns übermittelt. Dies sind:</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:list -->
                        <ul>
                            <!-- wp:list-item -->
                            <li>Browsertyp und Browserversion</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>verwendetes Betriebssystem</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Referrer URL</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Hostname des zugreifenden Rechners</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Uhrzeit der Serveranfrage</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>IP-Adresse</li>
                            <!-- /wp:list-item -->
                        </ul>
                        <!-- /wp:list -->

                        <!-- wp:paragraph -->
                        <p>Eine Zusammenführung dieser Daten mit anderen Datenquellen wird nicht vorgenommen. Die
                            Erfassung dieser Daten erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der
                            Websitebetreiber hat ein berechtigtes Interesse an der technisch fehlerfreien Darstellung
                            und der Optimierung seiner Website – hierzu müssen die Server-Log-Files erfasst werden.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Kontaktformular</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie uns per Kontaktformular Anfragen zukommen lassen, werden Ihre Angaben aus dem
                            Anfrageformular inklusive der von Ihnen dort angegebenen Kontaktdaten zwecks Bearbeitung der
                            Anfrage und für den Fall von Anschlussfragen bei uns gespeichert. Diese Daten geben wir
                            nicht ohne Ihre Einwilligung weiter. Die Verarbeitung der in das Kontaktformular
                            eingegebenen Daten erfolgt somit ausschließlich auf Grundlage Ihrer Einwilligung (Art. 6
                            Abs. 1 lit. a DSGVO). Sie können diese Einwilligung jederzeit widerrufen. Dazu reicht eine
                            formlose Mitteilung per E-Mail an uns. Die Rechtmäßigkeit der bis zum Widerruf erfolgten
                            Datenverarbeitungsvorgänge bleibt vom Widerruf unberührt. Die von Ihnen im Kontaktformular
                            eingegebenen Daten verbleiben bei uns, bis Sie uns zur Löschung auffordern, Ihre
                            Einwilligung zur Speicherung widerrufen oder der Zweck für die Datenspeicherung entfällt
                            (z.&nbsp;B. nach abgeschlossener Bearbeitung Ihrer Anfrage). Zwingende gesetzliche
                            Bestimmungen – insbesondere Aufbewahrungsfristen – bleiben unberührt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Anfrage per E-Mail, Telefon oder Telefax</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie uns per E-Mail, Telefon oder Telefax kontaktieren, wird Ihre Anfrage inklusive aller
                            daraus hervorgehenden personenbezogenen Daten (Name, Anfrage) zum Zwecke der Bearbeitung
                            Ihres Anliegens bei uns gespeichert und verarbeitet. Diese Daten geben wir nicht ohne Ihre
                            Einwilligung weiter.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Verarbeitung dieser Daten erfolgt auf Grundlage von Art. 6 Abs. 1 lit. b DSGVO, sofern
                            Ihre Anfrage mit der Erfüllung eines Vertrags zusammenhängt oder zur Durchführung
                            vorvertraglicher Maßnahmen erforderlich ist. In allen übrigen Fällen beruht die Verarbeitung
                            auf Ihrer Einwilligung (Art. 6 Abs. 1 lit. a DSGVO) und/oder auf unseren berechtigten
                            Interessen (Art. 6 Abs. 1 lit. f DSGVO), da wir ein berechtigtes Interesse an der effektiven
                            Bearbeitung der an uns gerichteten Anfragen haben.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die von Ihnen an uns per Kontaktanfragen übersandten Daten verbleiben bei uns, bis Sie uns
                            zur Löschung auffordern, Ihre Einwilligung zur Speicherung widerrufen oder der Zweck für die
                            Datenspeicherung entfällt (z.&nbsp;B. nach abgeschlossener Bearbeitung Ihres Anliegens).
                            Zwingende gesetzliche Bestimmungen – insbesondere gesetzliche Aufbewahrungsfristen – bleiben
                            unberührt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Registrierung auf dieser Website</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Sie können sich auf unserer Website registrieren, um zusätzliche Funktionen auf der Seite zu
                            nutzen. Die dazu eingegebenen Daten verwenden wir nur zum Zwecke der Nutzung des jeweiligen
                            Angebotes oder Dienstes, für den Sie sich registriert haben. Die bei der Registrierung
                            abgefragten Pflichtangaben müssen vollständig angegeben werden. Anderenfalls werden wir die
                            Registrierung ablehnen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Für wichtige Änderungen etwa beim Angebotsumfang oder bei technisch notwendigen Änderungen
                            nutzen wir die bei der Registrierung angegebene E-Mail-Adresse, um Sie auf diesem Wege zu
                            informieren.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Verarbeitung der bei der Registrierung eingegebenen Daten erfolgt auf Grundlage Ihrer
                            Einwilligung (Art. 6 Abs. 1 lit. a DSGVO). Sie können eine von Ihnen erteilte Einwilligung
                            jederzeit widerrufen. Dazu reicht eine formlose Mitteilung per E-Mail an uns. Die
                            Rechtmäßigkeit der bereits erfolgten Datenverarbeitung bleibt vom Widerruf unberührt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die bei der Registrierung erfassten Daten werden von uns gespeichert, solange Sie auf unserer
                            Website registriert sind und werden anschließend gelöscht. Gesetzliche Aufbewahrungsfristen
                            bleiben unberührt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Verarbeiten von Daten (Kunden- und Vertragsdaten)</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir erheben, verarbeiten und nutzen personenbezogene Daten nur, soweit sie für die
                            Begründung, inhaltliche Ausgestaltung oder Änderung des Rechtsverhältnisses erforderlich
                            sind (Bestandsdaten). Dies erfolgt auf Grundlage von Art. 6 Abs. 1 lit. b DSGVO, der die
                            Verarbeitung von Daten zur Erfüllung eines Vertrags oder vorvertraglicher Maßnahmen
                            gestattet. Personenbezogene Daten über die Inanspruchnahme unserer Internetseiten
                            (Nutzungsdaten) erheben, verarbeiten und nutzen wir nur, soweit dies erforderlich ist, um
                            dem Nutzer die Inanspruchnahme des Dienstes zu ermöglichen oder abzurechnen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die erhobenen Kundendaten werden nach Abschluss des Auftrags oder Beendigung der
                            Geschäftsbeziehung gelöscht. Gesetzliche Aufbewahrungsfristen bleiben unberührt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Datenübermittlung bei Vertragsschluss für Online-Shops, Händler und Warenversand</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir übermitteln personenbezogene Daten an Dritte nur dann, wenn dies im Rahmen der
                            Vertragsabwicklung notwendig ist, etwa an die mit der Lieferung der Ware betrauten
                            Unternehmen oder das mit der Zahlungsabwicklung beauftragte Kreditinstitut. Eine
                            weitergehende Übermittlung der Daten erfolgt nicht bzw. nur dann, wenn Sie der Übermittlung
                            ausdrücklich zugestimmt haben. Eine Weitergabe Ihrer Daten an Dritte ohne ausdrückliche
                            Einwilligung, etwa zu Zwecken der Werbung, erfolgt nicht.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Grundlage für die Datenverarbeitung ist Art. 6 Abs. 1 lit. b DSGVO, der die Verarbeitung von
                            Daten zur Erfüllung eines Vertrags oder vorvertraglicher Maßnahmen gestattet.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Datenübermittlung bei Vertragsschluss für Dienstleistungen und digitale Inhalte</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir übermitteln personenbezogene Daten an Dritte nur dann, wenn dies im Rahmen der
                            Vertragsabwicklung notwendig ist, etwa an das mit der Zahlungsabwicklung beauftragte
                            Kreditinstitut. Eine weitergehende Übermittlung der Daten erfolgt nicht bzw. nur dann, wenn
                            Sie der Übermittlung ausdrücklich zugestimmt haben. Eine Weitergabe Ihrer Daten an Dritte
                            ohne ausdrückliche Einwilligung, etwa zu Zwecken der Werbung, erfolgt nicht. Grundlage für
                            die Datenverarbeitung ist Art. 6 Abs. 1 lit. b DSGVO, der die Verarbeitung von Daten zur
                            Erfüllung eines Vertrags oder vorvertraglicher Maßnahmen gestattet.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Registrierung mit Facebook Connect</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Statt einer direkten Registrierung auf unserer Website können Sie sich mit Facebook Connect
                            registrieren. Anbieter dieses Dienstes ist die Facebook Ireland Limited, 4 Grand Canal
                            Square, Dublin 2, Irland.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie sich für die Registrierung mit Facebook Connect entscheiden und auf den „Login with
                            Facebook“-/„Connect with Facebook“-Button klicken, werden Sie automatisch auf die Plattform
                            von Facebook weitergeleitet. Dort können Sie sich mit Ihren Nutzungsdaten anmelden. Dadurch
                            wird Ihr Facebook-Profil mit unserer Website bzw. unseren Diensten verknüpft. Durch diese
                            Verknüpfung erhalten wir Zugriff auf Ihre bei Facebook hinterlegten Daten. Dies sind vor
                            allem:</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:list -->
                        <ul>
                            <!-- wp:list-item -->
                            <li>Facebook-Name</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Facebook-Profil- und Titelbild</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Facebook-Titelbild</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>bei Facebook hinterlegte E-Mail-Adresse</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Facebook-ID</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Facebook-Freundeslisten</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Facebook Likes („Gefällt-mir“-Angaben)</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Geburtstag</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Geschlecht</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Land</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Sprache</li>
                            <!-- /wp:list-item -->
                        </ul>
                        <!-- /wp:list -->

                        <!-- wp:paragraph -->
                        <p>Diese Daten werden zur Einrichtung, Bereitstellung und Personalisierung Ihres Accounts
                            genutzt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Registrierung mit Facebook-Connect und die damit verbundenen Datenverarbeitungsvorgänge
                            erfolgen auf Grundlage Ihrer Einwilligung (Art. 6 Abs. 1 lit. a DSGVO). Diese Einwilligung
                            können Sie jederzeit mit Wirkung für die Zukunft widerrufen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Weitere Informationen finden Sie in den Facebook-Nutzungsbedingungen und den
                            Facebook-Datenschutzbestimmungen. Diese finden Sie unter:&nbsp;<a
                                href="https://de-de.facebook.com/about/privacy/" target="_blank"
                                rel="noreferrer noopener">https://de-de.facebook.com/about/privacy/</a>&nbsp;und&nbsp;<a
                                href="https://de-de.facebook.com/legal/terms/" target="_blank"
                                rel="noreferrer noopener">https://de-de.facebook.com/legal/terms/</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Kommentarfunktion auf dieser Website</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Für die Kommentarfunktion auf dieser Seite werden neben Ihrem Kommentar auch Angaben zum
                            Zeitpunkt der Erstellung des Kommentars, Ihre E-Mail-Adresse und, wenn Sie nicht anonym
                            posten, der von Ihnen gewählte Nutzername gespeichert.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Speicherung der IP-Adresse</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Unsere Kommentarfunktion speichert die IP-Adressen der Nutzer, die Kommentare verfassen. Da
                            wir Kommentare auf unserer Seite nicht vor der Freischaltung prüfen, benötigen wir diese
                            Daten, um im Falle von Rechtsverletzungen wie Beleidigungen oder Propaganda gegen den
                            Verfasser vorgehen zu können.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Abonnieren von Kommentaren</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Als Nutzer der Seite können Sie nach einer Anmeldung Kommentare abonnieren. Sie erhalten eine
                            Bestätigungsemail, um zu prüfen, ob Sie der Inhaber der angegebenen E-Mail-Adresse sind. Sie
                            können diese Funktion jederzeit über einen Link in den Info-Mails abbestellen. Die im Rahmen
                            des Abonnierens von Kommentaren eingegebenen Daten werden in diesem Fall gelöscht; wenn Sie
                            diese Daten für andere Zwecke und an anderer Stelle (z.B. Newsletterbestellung) an uns
                            übermittelt haben, verbleiben die jedoch bei uns.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Speicherdauer der Kommentare</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Die Kommentare und die damit verbundenen Daten (z.&nbsp;B. IP-Adresse) werden gespeichert und
                            verbleiben auf unserer Website, bis der kommentierte Inhalt vollständig gelöscht wurde oder
                            die Kommentare aus rechtlichen Gründen gelöscht werden müssen (z.&nbsp;B. beleidigende
                            Kommentare).</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Rechtsgrundlage</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Die Speicherung der Kommentare erfolgt auf Grundlage Ihrer Einwilligung (Art. 6 Abs. 1 lit. a
                            DSGVO). Sie können eine von Ihnen erteilte Einwilligung jederzeit widerrufen. Dazu reicht
                            eine formlose Mitteilung per E-Mail an uns. Die Rechtmäßigkeit der bereits erfolgten
                            Datenverarbeitungsvorgänge bleibt vom Widerruf unberührt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":4} -->
                        <h4>Plugins und Tools</h4>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Google Web Fonts</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Diese Seite nutzt zur einheitlichen Darstellung von Schriftarten so genannte Web Fonts, die
                            von Google bereitgestellt werden. Die Google Fonts sind lokal installiert. Eine Verbindung
                            zu Servern von Google findet dabei nicht statt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Google Maps</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Diese Seite nutzt über eine API den Kartendienst Google Maps. Anbieter ist die Google Ireland
                            Limited („Google“), Gordon House, Barrow Street, Dublin 4, Irland.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Zur Nutzung der Funktionen von Google Maps ist es notwendig, Ihre IP Adresse zu speichern.
                            Diese Informationen werden in der Regel an einen Server von Google in den USA übertragen und
                            dort gespeichert. Der Anbieter dieser Seite hat keinen Einfluss auf diese Datenübertragung.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Nutzung von Google Maps erfolgt im Interesse einer ansprechenden Darstellung unserer
                            Online-Angebote und an einer leichten Auffindbarkeit der von uns auf der Website angegebenen
                            Orte. Dies stellt ein berechtigtes Interesse im Sinne von Art. 6 Abs. 1 lit. f DSGVO dar.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Mehr Informationen zum Umgang mit Nutzerdaten finden Sie in der Datenschutzerklärung von
                            Google:&nbsp;<a href="https://policies.google.com/privacy?hl=de" target="_blank"
                                rel="noreferrer noopener">https://policies.google.com/privacy?hl=de</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Adobe Fonts</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Unsere Website nutzt zur einheitlichen Darstellung bestimmter Schriftarten Web Fonts von
                            Adobe. Anbieter ist die Adobe Systems Incorporated, 345 Park Avenue, San Jose, CA
                            95110-2704, USA (Adobe).</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Beim Aufruf unserer Seiten lädt Ihr Browser die benötigten Schriftarten direkt von Adobe, um
                            sie Ihrem Endgerät korrekt anzeigen zu können. Dabei stellt Ihr Browser eine Verbindung zu
                            den Servern von Adobe in den USA her. Hierdurch erlangt Adobe Kenntnis darüber, dass über
                            Ihre IP-Adresse unsere Website aufgerufen wurde. Bei der Bereitstellung der Schriftarten
                            werden nach Aussage von Adobe keine Cookies gespeichert.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Adobe verfügt über eine Zertifizierung nach dem EU-US-Privacy-Shield. Der Privacy-Shield ist
                            ein Abkommen zwischen den Vereinigten Staaten von Amerika und der Europäischen Union, das
                            die Einhaltung europäischer Datenschutzstandards gewährleisten soll. Nähere Informationen
                            finden Sie unter:&nbsp;<a href="https://www.adobe.com/de/privacy/eudatatransfers.html"
                                target="_blank"
                                rel="noreferrer noopener">https://www.adobe.com/de/privacy/eudatatransfers.html</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Nutzung von Adobe Fonts ist erforderlich, um ein einheitliches Schriftbild auf unserer
                            Website zu gewährleisten. Dies stellt ein berechtigtes Interesse im Sinne des Art. 6 Abs. 1
                            lit. f DSGVO dar.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Nähere Informationen zu Adobe Fonts erhalten Sie unter:&nbsp;<a
                                href="https://www.adobe.com/de/privacy/policies/adobe-fonts.html" target="_blank"
                                rel="noreferrer noopener">https://www.adobe.com/de/privacy/policies/adobe-fonts.html</a>.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Datenschutzerklärung von Adobe finden Sie unter:&nbsp;<a
                                href="https://www.adobe.com/de/privacy/policy.html" target="_blank"
                                rel="noreferrer noopener">https://www.adobe.com/de/privacy/policy.html</a></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>YouTube mit erweitertem Datenschutz</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Unsere Website nutzt Plugins der Website YouTube. Betreiber der Seiten ist die Google Ireland
                            Limited („Google“), Gordon House, Barrow Street, Dublin 4, Irland.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wir nutzen YouTube im erweiterten Datenschutzmodus. Dieser Modus bewirkt laut YouTube, dass
                            YouTube keine Informationen über die Besucher auf dieser Website speichert, bevor diese sich
                            das Video ansehen. Die Weitergabe von Daten an YouTube-Partner wird durch den erweiterten
                            Datenschutzmodus hingegen nicht zwingend ausgeschlossen. So stellt YouTube – unabhängig
                            davon, ob Sie sich ein Video ansehen – eine Verbindung zum Google DoubleClick-Netzwerk her.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sobald Sie ein YouTube-Video auf unserer Website starten, wird eine Verbindung zu den Servern
                            von YouTube hergestellt. Dabei wird dem YouTube-Server mitgeteilt, welche unserer Seiten Sie
                            besucht haben. Wenn Sie in Ihrem YouTube-Account eingeloggt sind, ermöglichen Sie YouTube,
                            Ihr Surfverhalten direkt Ihrem persönlichen Profil zuzuordnen. Dies können Sie verhindern,
                            indem Sie sich aus Ihrem YouTube-Account ausloggen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Des Weiteren kann YouTube nach Starten eines Videos verschiedene Cookies auf Ihrem Endgerät
                            speichern. Mit Hilfe dieser Cookies kann YouTube Informationen über Besucher unserer Website
                            erhalten. Diese Informationen werden u. a. verwendet, um Videostatistiken zu erfassen, die
                            Anwenderfreundlichkeit zu verbessern und Betrugsversuchen vorzubeugen. Die Cookies
                            verbleiben auf Ihrem Endgerät, bis Sie sie löschen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Gegebenenfalls können nach dem Start eines YouTube-Videos weitere Datenverarbeitungsvorgänge
                            ausgelöst werden, auf die wir keinen Einfluss haben.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Nutzung von YouTube erfolgt im Interesse einer ansprechenden Darstellung unserer
                            Online-Angebote. Dies stellt ein berechtigtes Interesse im Sinne von Art. 6 Abs. 1 lit. f
                            DSGVO dar.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Weitere Informationen über Datenschutz bei YouTube finden Sie in deren Datenschutzerklärung
                            unter:&nbsp;<a href="https://policies.google.com/privacy?hl=de" target="_blank"
                                rel="noreferrer noopener">https://policies.google.com/privacy?hl=de</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Vimeo</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Unsere Website nutzt Plugins des Videoportals Vimeo. Anbieter ist die Vimeo Inc., 555 West
                            18th Street, New York, New York 10011, USA.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie eine unserer mit einem Vimeo-Plugin ausgestatteten Seiten besuchen, wird eine
                            Verbindung zu den Servern von Vimeo hergestellt. Dabei wird dem Vimeo-Server mitgeteilt,
                            welche unserer Seiten Sie besucht haben. Zudem erlangt Vimeo Ihre IP-Adresse. Dies gilt auch
                            dann, wenn Sie nicht bei Vimeo eingeloggt sind oder keinen Account bei Vimeo besitzen. Die
                            von Vimeo erfassten Informationen werden an den Vimeo-Server in den USA übermittelt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie in Ihrem Vimeo-Account eingeloggt sind, ermöglichen Sie Vimeo, Ihr Surfverhalten
                            direkt Ihrem persönlichen Profil zuzuordnen. Dies können Sie verhindern, indem Sie sich aus
                            Ihrem Vimeo-Account ausloggen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Nutzung von Vimeo erfolgt im Interesse einer ansprechenden Darstellung unserer
                            Online-Angebote. Dies stellt ein berechtigtes Interesse im Sinne des Art. 6 Abs. 1 lit. f
                            DSGVO dar.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Weitere Informationen zum Umgang mit Nutzerdaten finden Sie in der Datenschutzerklärung von
                            Vimeo unter:&nbsp;<a href="https://vimeo.com/privacy" target="_blank"
                                rel="noreferrer noopener">https://vimeo.com/privacy</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>SoundCloud</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Auf unseren Seiten können Plugins des sozialen Netzwerks SoundCloud (SoundCloud Limited,
                            Berners House, 47-48 Berners Street, London W1T 3NF, Großbritannien.) integriert sein. Die
                            SoundCloud-Plugins erkennen Sie an dem SoundCloud-Logo auf den betroffenen Seiten.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie unsere Seiten besuchen, wird nach Aktivierung des Plugin eine direkte Verbindung
                            zwischen Ihrem Browser und dem SoundCloud-Server hergestellt. SoundCloud erhält dadurch die
                            Information, dass Sie mit Ihrer IP-Adresse unsere Seite besucht haben. Wenn Sie den
                            „Like-Button“ oder „Share-Button“ anklicken während Sie in Ihrem SoundCloud- Benutzerkonto
                            eingeloggt sind, können Sie die Inhalte unserer Seiten mit Ihrem SoundCloud-Profil verlinken
                            und/oder teilen. Dadurch kann SoundCloud Ihrem Benutzerkonto den Besuch unserer Seiten
                            zuordnen. Wir weisen darauf hin, dass wir als Anbieter der Seiten keine Kenntnis vom Inhalt
                            der übermittelten Daten sowie deren Nutzung durch SoundCloud erhalten.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Nutzung von SoundCloud erfolgt auf Grundlage des Art. 6 Abs. 1 lit. f DSGVO. Der
                            Websitebetreiber hat ein berechtigtes Interesse an einer möglichst umfangreichen
                            Sichtbarkeit in den Sozialen Medien.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Weitere Informationen hierzu finden Sie in der Datenschutzerklärung von SoundCloud
                            unter:&nbsp;<a href="https://soundcloud.com/pages/privacy" target="_blank"
                                rel="noreferrer noopener">https://soundcloud.com/pages/privacy</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie nicht wünschen, dass SoundCloud den Besuch unserer Seiten Ihrem SoundCloud-
                            Benutzerkonto zuordnet, loggen Sie sich bitte aus Ihrem SoundCloud-Benutzerkonto aus bevor
                            Sie Inhalte des SoundCloud-Plugins aktivieren.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Spotify</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Auf unseren Seiten sind Funktionen des Musik-Dienstes Spotify eingebunden. Anbieter ist die
                            Spotify AB, Birger Jarlsgatan 61, 113 56 Stockholm in Schweden. Die Spotify Plugins erkennen
                            Sie an dem grünen Logo auf unserer Seite. Eine Übersicht über die Spotify-Plugins finden Sie
                            unter:&nbsp;<a href="https://developer.spotify.com/" target="_blank"
                                rel="noreferrer noopener">https://developer.spotify.com</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Dadurch kann beim Besuch unserer Seiten über das Plugin eine direkte Verbindung zwischen
                            Ihrem Browser und dem Spotify-Server hergestellt werden. Spotify erhält dadurch die
                            Information, dass Sie mit Ihrer IP-Adresse unsere Seite besucht haben. Wenn Sie den Spotify
                            Button anklicken während Sie in Ihrem Spotify-Account eingeloggt sind, können Sie die
                            Inhalte unserer Seiten auf Ihrem Spotify Profil verlinken. Dadurch kann Spotify den Besuch
                            unserer Seiten Ihrem Benutzerkonto zuordnen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Datenverarbeitung erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der
                            Websitebetreiber hat ein berechtigtes Interesse an der ansprechenden akustischen
                            Ausgestaltung seiner Website.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Weitere Informationen hierzu finden Sie in der Datenschutzerklärung von Spotify:&nbsp;<a
                                href="https://www.spotify.com/de/legal/privacy-policy/" target="_blank"
                                rel="noreferrer noopener">https://www.spotify.com/de/legal/privacy-policy/</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie nicht wünschen, dass Spotify den Besuch unserer Seiten Ihrem Spotify-Nutzerkonto
                            zuordnen kann, loggen Sie sich bitte aus Ihrem Spotify-Benutzerkonto aus.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Zendesk</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Zur Bearbeitung von Nutzeranfragen verwenden wir das CRM-System Zendesk. Anbieter ist die
                            Zendesk, Inc, 1019 Market Street in San Francisco, CA 94103 USA.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wir nutzen Zendesk, um Ihre Anfragen schnell und effizient bearbeiten zu können.
                            Rechtsgrundlage für die Verarbeitung Ihrer Daten ist das berechtigte Interesse auf Grundlage
                            von Art. 6 Abs. 1 lit. f DSGVO.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Zendesk ist als US-amerikanischer Anbieter Privacy-Shield zertifiziert und verpflichtet sich
                            dadurch, das Datenschutzrecht der EU einzuhalten. Zusätzlich haben wir mit Zendesk einen
                            Vertrag über Auftragsverarbeitung (Data Processing Agreement, DPA) abgeschlossen. Dadurch
                            ist sichergestellt, dass Zendesk die Nutzer-Daten nur im Rahmen der EU-Datenschutznormen
                            ausschließlich zur Verarbeitung der Anfragen nutzt und diese nicht an Dritte weiter gibt.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sie können Anfragen nur mit Angabe der E-Mail-Adresse und ohne Angaben Ihres Namens absenden.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sollten Sie nicht mit der Bearbeitung Ihrer Anfrage bei uns über Zendesk einverstanden sein,
                            können Sie alternativ per E-Mail, Telefon oder Fax mit uns kommunizieren.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Weitere Informationen erhalten Sie in der Datenschutzerklärung von Zendesk:&nbsp;<a
                                href="https://www.zendesk.de/company/customers-partners/privacy-policy/"
                                target="_blank"
                                rel="noreferrer noopener">https://www.zendesk.de/company/customers-partners/privacy-policy/</a>.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Google reCAPTCHA</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir nutzen „Google reCAPTCHA“ (im Folgenden „reCAPTCHA“) auf unseren Websites. Anbieter ist
                            die Google Ireland Limited („Google“), Gordon House, Barrow Street, Dublin 4, Irland.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Mit reCAPTCHA soll überprüft werden, ob die Dateneingabe auf unseren Websites (z.&nbsp;B. in
                            einem Kontaktformular) durch einen Menschen oder durch ein automatisiertes Programm erfolgt.
                            Hierzu analysiert reCAPTCHA das Verhalten des Websitebesuchers anhand verschiedener
                            Merkmale. Diese Analyse beginnt automatisch, sobald der Websitebesucher die Website betritt.
                            Zur Analyse wertet reCAPTCHA verschiedene Informationen aus (z.&nbsp;B. IP-Adresse,
                            Verweildauer des Websitebesuchers auf der Website oder vom Nutzer getätigte Mausbewegungen).
                            Die bei der Analyse erfassten Daten werden an Google weitergeleitet.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die reCAPTCHA-Analysen laufen vollständig im Hintergrund. Websitebesucher werden nicht darauf
                            hingewiesen, dass eine Analyse stattfindet.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Datenverarbeitung erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der
                            Websitebetreiber hat ein berechtigtes Interesse daran, seine Webangebote vor
                            missbräuchlicher automatisierter Ausspähung und vor SPAM zu schützen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Weitere Informationen zu Google reCAPTCHA sowie die Datenschutzerklärung von Google entnehmen
                            Sie folgenden Links:&nbsp;<a href="https://policies.google.com/privacy?hl=de"
                                target="_blank"
                                rel="noreferrer noopener">https://policies.google.com/privacy?hl=de</a>&nbsp;und&nbsp;<a
                                href="https://www.google.com/recaptcha/intro/v3.html" target="_blank"
                                rel="noreferrer noopener">https://www.google.com/recaptcha/intro/v3.htmll</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Einsatz von EverCAPTCHA</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Zur Absicherung unseres Kontaktformulars gegen unerwünschte Verwendung nutzen wir den Dienst
                            EverCAPTCHA unseres Website-Erstellers und Hosters Internet Online Media GmbH, Hetmanekgasse
                            1b, 1230 Wien. Dieser Dienst wird bereitgestellt durch den Unterauftragsdatenverarbeiter:
                            wwwe GmbH, Hansaallee 299, 40549 Düsseldorf. EverCAPTCHA ermöglicht die Unterscheidung, ob
                            die Eingabe der Daten in das Kontaktformular tatsächlich durch einen Menschen oder
                            missbräuchlich automatisiert durch eine Maschine, einem so genannten Spambot erfolgt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Zu diesem Zweck werden bei Verwendung unserer Formulare diverse Fragen gestellt (etwa:
                            „Klicken Sie ein Symbol X an“ etc.). EverCAPTCHA speichert hierbei alle Fehlversuche eines
                            Nutzers, eine IP-Adresse über eine Session ID, die im LocalStorage gespeichert wird. Die
                            Session ID wird per JavaScript bei jeder Anfrage an den Server übermittelt. Erfolgen 30
                            Fehleingaben, wird die IP-Adresse des Nutzers dauerhaft in einer Datenbank zur Spamabwehr
                            gespeichert. Im Übrigen erfolgt eine Löschung der IP-Adressen binnen 7 Tagen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":4} -->
                        <h4>Soziale Medien</h4>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Social-Media-Plugins mit Shariff</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Auf unseren Seiten werden Plugins von sozialen Medien verwendet (z.&nbsp;B. Facebook,
                            Twitter, Google+, Instagram, Pinterest, XING, LinkedIn, Tumblr).</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Plugins können Sie in der Regel anhand der jeweiligen Social-Media-Logos erkennen. Um den
                            Datenschutz auf unserer Website zu gewährleisten, verwenden wir diese Plugins nur zusammen
                            mit der sogenannten „Shariff“-Lösung. Diese Anwendung verhindert, dass die auf unserer
                            Website integrierten Plugins Daten schon beim ersten Betreten der Seite an den jeweiligen
                            Anbieter übertragen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Erst wenn Sie das jeweilige Plugin durch Anklicken der zugehörigen Schaltfläche aktivieren,
                            wird eine direkte Verbindung zum Server des Anbieters hergestellt (Einwilligung). Sobald Sie
                            das Plugin aktivieren, erhält der jeweilige Anbieter die Information, dass Sie mit Ihrer
                            IP-Adresse unsere Seite besucht haben. Wenn Sie gleichzeitig in Ihrem jeweiligen
                            Social-Media-Account (z.&nbsp;B. Facebook) eingeloggt sind, kann der jeweilige Anbieter den
                            Besuch unserer Seiten Ihrem Benutzerkonto zuordnen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Das Aktivieren des Plugins stellt eine Einwilligung im Sinne des Art. 6 Abs. 1 lit. a DSGVO
                            dar. Diese Einwilligung können Sie jederzeit mit Wirkung für die Zukunft widerrufen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Facebook-Plugins (Like &amp; Share-Button)</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Auf unseren Seiten sind Plugins des sozialen Netzwerks Facebook, Anbieter Facebook Inc., 1
                            Hacker Way, Menlo Park, California 94025, USA, integriert. Die Facebook Plugins erkennen Sie
                            an dem Facebook-Logo oder dem „Like-Button“ („Gefällt mir“) auf unserer Seite. Eine
                            Übersicht über die Facebook Plugins finden Sie hier:&nbsp;<a
                                href="https://developers.facebook.com/docs/plugins/?locale=de_DE" target="_blank"
                                rel="noreferrer noopener">https://developers.facebook.com/docs/plugins/?locale=de_DE</a>.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie unsere Seiten besuchen, wird über das Plugin eine direkte Verbindung zwischen Ihrem
                            Browser und dem Facebook-Server hergestellt. Facebook erhält dadurch die Information, dass
                            Sie mit Ihrer IP-Adresse unsere Seite besucht haben. Wenn Sie den Facebook „Like-Button“
                            anklicken während Sie in Ihrem Facebook-Account eingeloggt sind, können Sie die Inhalte
                            unserer Seiten auf Ihrem Facebook-Profil verlinken. Dadurch kann Facebook den Besuch unserer
                            Seiten Ihrem Benutzerkonto zuordnen. Wir weisen darauf hin, dass wir als Anbieter der Seiten
                            keine Kenntnis vom Inhalt der übermittelten Daten sowie deren Nutzung durch Facebook
                            erhalten. Weitere Informationen hierzu finden Sie in der Datenschutzerklärung von Facebook
                            unter:&nbsp;<a href="https://de-de.facebook.com/privacy/explanation" target="_blank"
                                rel="noreferrer noopener">https://de-de.facebook.com/privacy/explanation</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie nicht wünschen, dass Facebook den Besuch unserer Seiten Ihrem Facebook-Nutzerkonto
                            zuordnen kann, loggen Sie sich bitte aus Ihrem Facebook-Benutzerkonto aus. Die Verwendung
                            der Facebook Plugins erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der
                            Websitebetreiber hat ein berechtigtes Interesse an einer möglichst umfangreichen
                            Sichtbarkeit in den Sozialen Medien.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Einsatz von juicer.io</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Auf dieser Website haben wir ein Tool zur Implementierung von Social Media Inhalten des
                            Anbieters saas.group LLC, 304 S. Jones Blvd #1205, Las Vegas NV 89107, USA eingebunden.
                            Einzelheiten zu den im Zusammenhang mit dem Dienst erfolgenden Datenverarbeitungen stehen in
                            der Datenschutzerklärung des Anbieters,&nbsp;<a href="https://www.juicer.io/privacy"
                                target="_blank" rel="noreferrer noopener">https://www.juicer.io/privacy</a>. Die
                            Rechtsgrundlage für die Einbindung des Tools ist Art. 6 Abs. 1 lit. f DSGVO. In der
                            Optimierung der Nutzerfreundlichkeit der Website und der Ermöglichung der Einbindung von
                            Social Media Beiträgen liegt unser berechtigtes Interesse.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Twitter Plugin</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Auf unseren Seiten sind Funktionen des Dienstes Twitter eingebunden. Diese Funktionen werden
                            angeboten durch die Twitter Inc., 1355 Market Street, Suite 900, San Francisco, CA 94103,
                            USA. Durch das Benutzen von Twitter und der Funktion „Re-Tweet“ werden die von Ihnen
                            besuchten Websites mit Ihrem Twitter-Account verknüpft und anderen Nutzern bekannt gegeben.
                            Dabei werden auch Daten an Twitter übertragen. Wir weisen darauf hin, dass wir als Anbieter
                            der Seiten keine Kenntnis vom Inhalt der übermittelten Daten sowie deren Nutzung durch
                            Twitter erhalten. Weitere Informationen hierzu finden Sie in der Datenschutzerklärung von
                            Twitter unter:&nbsp;<a href="https://twitter.com/de/privacy" target="_blank"
                                rel="noreferrer noopener">https://twitter.com/de/privacy</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Verwendung des Twitter-Plugins erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der
                            Websitebetreiber hat ein berechtigtes Interesse an einer möglichst umfangreichen
                            Sichtbarkeit in den Sozialen Medien. Ihre Datenschutzeinstellungen bei Twitter können Sie in
                            den Konto-Einstellungen unter&nbsp;<a href="https://twitter.com/account/settings"
                                target="_blank"
                                rel="noreferrer noopener">https://twitter.com/account/settings</a>&nbsp;ändern.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Google+ Plugin</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Anbieter ist die Google Ireland Limited („Google“), Gordon House, Barrow Street, Dublin 4,
                            Irland.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Erfassung und Weitergabe von Informationen: Mithilfe der Google+-Schaltfläche können Sie
                            Informationen weltweit veröffentlichen. Über die Google+-Schaltfläche erhalten Sie und
                            andere Nutzer personalisierte Inhalte von Google und unseren Partnern. Google speichert
                            sowohl die Information, dass Sie für einen Inhalt +1 gegeben haben, als auch Informationen
                            über die Seite, die Sie beim Klicken auf +1 angesehen haben. Ihre +1 können als Hinweise
                            zusammen mit Ihrem Profilnamen und Ihrem Foto in Google-Diensten, wie etwa in
                            Suchergebnissen oder in Ihrem Google-Profil, oder an anderen Stellen auf Websites und
                            Anzeigen im Internet eingeblendet werden.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Google zeichnet Informationen über Ihre +1-Aktivitäten auf, um die Google-Dienste für Sie und
                            andere zu verbessern. Um die Google+-Schaltfläche verwenden zu können, benötigen Sie ein
                            weltweit sichtbares, öffentliches Google-Profil, das zumindest den für das Profil gewählten
                            Namen enthalten muss. Dieser Name wird in allen Google-Diensten verwendet. In manchen Fällen
                            kann dieser Name auch einen anderen Namen ersetzen, den Sie beim Teilen von Inhalten über
                            Ihr Google-Konto verwendet haben. Die Identität Ihres Google-Profils kann Nutzern angezeigt
                            werden, die Ihre E-Mail-Adresse kennen oder über andere identifizierende Informationen von
                            Ihnen verfügen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Verwendung der erfassten Informationen: Neben den oben erläuterten Verwendungszwecken werden
                            die von Ihnen bereitgestellten Informationen gemäß den geltenden
                            Google-Datenschutzbestimmungen genutzt. Google veröffentlicht möglicherweise
                            zusammengefasste Statistiken über die +1-Aktivitäten der Nutzer bzw. gibt diese an Nutzer
                            und Partner weiter, wie etwa Publisher, Inserenten oder verbundene Websites. Die Verwendung
                            des Google+-Plugins erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der
                            Websitebetreiber hat ein berechtigtes Interesse an einer möglichst umfangreichen
                            Sichtbarkeit in den Sozialen Medien.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Instagram Plugin</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Auf unseren Seiten sind Funktionen des Dienstes Instagram eingebunden. Diese Funktionen
                            werden angeboten durch die Instagram Inc., 1601 Willow Road, Menlo Park, CA 94025, USA
                            integriert.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie in Ihrem Instagram-Account eingeloggt sind, können Sie durch Anklicken des
                            Instagram-Buttons die Inhalte unserer Seiten mit Ihrem Instagram-Profil verlinken. Dadurch
                            kann Instagram den Besuch unserer Seiten Ihrem Benutzerkonto zuordnen. Wir weisen darauf
                            hin, dass wir als Anbieter der Seiten keine Kenntnis vom Inhalt der übermittelten Daten
                            sowie deren Nutzung durch Instagram erhalten.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Verwendung des Instagram-Plugins erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO.
                            Der Websitebetreiber hat ein berechtigtes Interesse an einer möglichst umfangreichen
                            Sichtbarkeit in den Sozialen Medien.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Weitere Informationen hierzu finden Sie in der Datenschutzerklärung von Instagram:&nbsp;<a
                                href="https://instagram.com/about/legal/privacy/" target="_blank"
                                rel="noreferrer noopener">https://instagram.com/about/legal/privacy/</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Tumblr Plugin</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Unsere Seiten nutzen Schaltflächen des Dienstes Tumblr. Anbieter ist die Tumblr, Inc., 35
                            East 21st St, 10th Floor, New York, NY 10010, USA.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Diese Schaltflächen ermöglichen es Ihnen, einen Beitrag oder eine Seite bei Tumblr zu teilen
                            oder dem Anbieter bei Tumblr zu folgen. Wenn Sie eine unserer Websites mit Tumblr-Button
                            aufrufen, baut der Browser eine direkte Verbindung mit den Servern von Tumblr auf. Wir haben
                            keinen Einfluss auf den Umfang der Daten, die Tumblr mit Hilfe dieses Plugins erhebt und
                            übermittelt. Nach aktuellem Stand werden die IP-Adresse des Nutzers sowie die URL der
                            jeweiligen Website übermittelt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Verwendung des Tumblr-Plugins erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der
                            Websitebetreiber hat ein berechtigtes Interesse an einer möglichst umfangreichen
                            Sichtbarkeit in den Sozialen Medien.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Weitere Informationen hierzu finden sich in der Datenschutzerklärung von Tumblr
                            unter:&nbsp;<a href="https://www.tumblr.com/privacy/de" target="_blank"
                                rel="noreferrer noopener">https://www.tumblr.com/privacy/de</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>LinkedIn Plugin</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Unsere Website nutzt Funktionen des Netzwerks LinkedIn. Anbieter ist die LinkedIn
                            Corporation, 2029 Stierlin Court, Mountain View, CA 94043, USA.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Bei jedem Abruf einer unserer Seiten, die Funktionen von LinkedIn enthält, wird eine
                            Verbindung zu Servern von LinkedIn aufgebaut. LinkedIn wird darüber informiert, dass Sie
                            unsere Internetseiten mit Ihrer IP-Adresse besucht haben. Wenn Sie den „Recommend-Button“
                            von LinkedIn anklicken und in Ihrem Account bei LinkedIn eingeloggt sind, ist es LinkedIn
                            möglich, Ihren Besuch auf unserer Internetseite Ihnen und Ihrem Benutzerkonto zuzuordnen.
                            Wir weisen darauf hin, dass wir als Anbieter der Seiten keine Kenntnis vom Inhalt der
                            übermittelten Daten sowie deren Nutzung durch LinkedIn haben.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Verwendung des LinkedIn-Plugins erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der
                            Websitebetreiber hat ein berechtigtes Interesse an einer möglichst umfangreichen
                            Sichtbarkeit in den Sozialen Medien.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Weitere Informationen hierzu finden Sie in der Datenschutzerklärung von LinkedIn
                            unter:&nbsp;<a href="https://www.linkedin.com/legal/privacy-policy" target="_blank"
                                rel="noreferrer noopener">https://www.linkedin.com/legal/privacy-policy</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>XING Plugin</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Unsere Website nutzt Funktionen des Netzwerks XING. Anbieter ist die XING AG, Dammtorstraße
                            29-32, 20354 Hamburg, Deutschland.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Bei jedem Abruf einer unserer Seiten, die Funktionen von XING enthält, wird eine Verbindung
                            zu Servern von XING hergestellt. Eine Speicherung von personenbezogenen Daten erfolgt dabei
                            nach unserer Kenntnis nicht. Insbesondere werden keine IP-Adressen gespeichert oder das
                            Nutzungsverhalten ausgewertet.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Verwendung des XING-Plugins erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der
                            Websitebetreiber hat ein berechtigtes Interesse an einer möglichst umfangreichen
                            Sichtbarkeit in den Sozialen Medien.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Weitere Information zum Datenschutz und dem XING Share-Button finden Sie in der
                            Datenschutzerklärung von XING unter:&nbsp;<a
                                href="https://www.xing.com/app/share?op=data_protection" target="_blank"
                                rel="noreferrer noopener">https://www.xing.com/app/share?op=data_protection</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Pinterest Plugin</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Auf unserer Seite verwenden wir Social Plugins des sozialen Netzwerkes Pinterest, das von der
                            Pinterest Inc., 808 Brannan Street, San Francisco, CA 94103-490, USA („Pinterest“) betrieben
                            wird.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie eine Seite aufrufen, die ein solches Plugin enthält, stellt Ihr Browser eine direkte
                            Verbindung zu den Servern von Pinterest her. Das Plugin übermittelt dabei Protokolldaten an
                            den Server von Pinterest in die USA. Diese Protokolldaten enthalten möglicherweise Ihre
                            IP-Adresse, die Adresse der besuchten Websites, die ebenfalls Pinterest-Funktionen
                            enthalten, Art und Einstellungen des Browsers, Datum und Zeitpunkt der Anfrage, Ihre
                            Verwendungsweise von Pinterest sowie Cookies.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Verwendung des Pinterest-Plugins erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO.
                            Der Websitebetreiber hat ein berechtigtes Interesse an einer möglichst umfangreichen
                            Sichtbarkeit in den Sozialen Medien.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Weitere Informationen zu Zweck, Umfang und weiterer Verarbeitung und Nutzung der Daten durch
                            Pinterest sowie Ihre diesbezüglichen Rechte und Möglichkeiten zum Schutz Ihrer Privatsphäre
                            finden Sie in den Datenschutzhinweisen von Pinterest:&nbsp;<a
                                href="https://policy.pinterest.com/de/privacy-policy" target="_blank"
                                rel="noreferrer noopener">https://policy.pinterest.com/de/privacy-policy</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":4} -->
                        <h4>Analyse Tools und Werbung</h4>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Hotjar</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Diese Website nutzt Hotjar. Anbieter ist die Hotjar Ltd., Level 2, St Julians Business
                            Centre, 3, Elia Zammit Street, St Julians STJ 1000, Malta, Europe (Website:&nbsp;<a
                                href="https://www.hotjar.com/" target="_blank"
                                rel="noreferrer noopener">https://www.hotjar.com</a>).</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Hotjar ist ein Werkzeug zur Analyse Ihres Nutzerverhaltens auf unserer Website. Mit Hotjar
                            können wir u. a. Ihre Maus- und Scrollbewegungen und Klicks aufzeichnen. Hotjar kann dabei
                            auch feststellen, wie lange Sie mit dem Mauszeiger auf einer bestimmten Stelle verblieben
                            sind. Aus diesen Informationen erstellt Hotjar sogenannte Heatmaps, mit denen sich
                            feststellen lässt, welche Websitebereiche vom Websitebesucher bevorzugt angeschaut werden.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Des Weiteren können wir feststellen, wie lange Sie auf einer Seite verblieben sind und wann
                            Sie sie verlassen haben. Wir können auch feststellen, an welcher Stelle Sie Ihre Eingaben in
                            ein Kontaktformular abgebrochen haben (sog. Conversion-Funnels).</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Darüber hinaus können mit Hotjar direkte Feedbacks von Websitebesuchern eingeholt werden.
                            Diese Funktion dient der Verbesserung der Webangebote des Websitebetreibers.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Hotjar verwendet Cookies. Cookies sind kleine Textdateien, die auf Ihrem Rechner abgelegt
                            werden und die Ihr Browser speichert. Sie dienen dazu, unser Angebot nutzerfreundlicher,
                            effektiver und sicherer zu machen. Mit diesen Cookies lässt sich insbesondere feststellen,
                            ob unsere Website mit einem bestimmten Endgerät besucht wurde oder ob die Funktionen von
                            Hotjar für den betreffenden Browser deaktiviert wurde. Hotjar-Cookies verbleiben auf Ihrem
                            Endgerät, bis Sie sie löschen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sie können Ihren Browser so einstellen, dass Sie über das Setzen von Cookies informiert
                            werden und Cookies nur im Einzelfall erlauben, die Annahme von Cookies für bestimmte Fälle
                            oder generell ausschließen sowie das automatische Löschen der Cookies beim Schließen des
                            Browsers aktivieren. Bei der Deaktivierung von Cookies kann die Funktionalität dieser
                            Website eingeschränkt sein.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Nutzung von Hotjar und die Speicherung von Hotjar-Cookies erfolgt auf Grundlage von Art.
                            6 Abs. 1 lit. f DSGVO. Der Websitebetreiber hat ein berechtigtes Interesse an der Analyse
                            des Nutzerverhaltens, um sowohl sein Webangebot als auch seine Werbung zu optimieren.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Deaktivieren von Hotjar</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie die Datenerfassung durch Hotjar deaktivieren möchten, klicken Sie auf folgenden Link
                            und folgen Sie den dortigen Anweisungen:&nbsp;<a
                                href="https://www.hotjar.com/policies/do-not-track/" target="_blank"
                                rel="noreferrer noopener">https://www.hotjar.com/policies/do-not-track/</a></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Bitte beachten Sie, dass die Deaktivierung von Hotjar für jeden Browser bzw. für jedes
                            Endgerät separat erfolgen muss.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Nähere Informationen über Hotjar und zu den erfassten Daten entnehmen Sie der
                            Datenschutzerklärung von Hotjar unter dem folgenden Link:&nbsp;<a
                                href="https://www.hotjar.com/legal/policies/privacy/" target="_blank"
                                rel="noreferrer noopener">https://www.hotjar.com/legal/policies/privacy/</a></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Vertrag über Auftragsverarbeitung</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir haben einen Vertrag über Auftragsverarbeitung mit Hotjar geschlossen, um die strengen
                            europäischen Datenschutzvorschriften umzusetzen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Google Analytics</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Diese Website nutzt Funktionen des Webanalysedienstes Google Analytics. Anbieter ist die
                            Google Ireland Limited („Google“), Gordon House, Barrow Street, Dublin 4, Irland.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Google Analytics verwendet so genannte „Cookies“. Das sind Textdateien, die auf Ihrem
                            Computer gespeichert werden und die eine Analyse der Benutzung der Website durch Sie
                            ermöglichen. Die durch den Cookie erzeugten Informationen über Ihre Benutzung dieser Website
                            werden in der Regel an einen Server von Google in den USA übertragen und dort gespeichert.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Speicherung von Google-Analytics-Cookies und die Nutzung dieses Analyse-Tools erfolgen
                            auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der Websitebetreiber hat ein berechtigtes
                            Interesse an der Analyse des Nutzerverhaltens, um sowohl sein Webangebot als auch seine
                            Werbung zu optimieren.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>IP-Anonymisierung</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir haben auf dieser Website die Funktion IP-Anonymisierung aktiviert. Dadurch wird Ihre
                            IP-Adresse von Google innerhalb von Mitgliedstaaten der Europäischen Union oder in anderen
                            Vertragsstaaten des Abkommens über den Europäischen Wirtschaftsraum vor der Übermittlung in
                            die USA gekürzt. Nur in Ausnahmefällen wird die volle IP-Adresse an einen Server von Google
                            in den USA übertragen und dort gekürzt. Im Auftrag des Betreibers dieser Website wird Google
                            diese Informationen benutzen, um Ihre Nutzung der Website auszuwerten, um Reports über die
                            Websiteaktivitäten zusammenzustellen und um weitere mit der Websitenutzung und der
                            Internetnutzung verbundene Dienstleistungen gegenüber dem Websitebetreiber zu erbringen. Die
                            im Rahmen von Google Analytics von Ihrem Browser übermittelte IP-Adresse wird nicht mit
                            anderen Daten von Google zusammengeführt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Browser Plugin</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Sie können die Speicherung der Cookies durch eine entsprechende Einstellung Ihrer
                            Browser-Software verhindern; wir weisen Sie jedoch darauf hin, dass Sie in diesem Fall
                            gegebenenfalls nicht sämtliche Funktionen dieser Website vollumfänglich werden nutzen
                            können. Sie können darüber hinaus die Erfassung der durch den Cookie erzeugten und auf Ihre
                            Nutzung der Website bezogenen Daten (inkl. Ihrer IP-Adresse) an Google sowie die
                            Verarbeitung dieser Daten durch Google verhindern, indem Sie das unter dem folgenden Link
                            verfügbare Browser-Plugin herunterladen und installieren:&nbsp;<a
                                href="https://tools.google.com/dlpage/gaoptout?hl=de" target="_blank"
                                rel="noreferrer noopener">https://tools.google.com/dlpage/gaoptout?hl=de</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Widerspruch gegen Datenerfassung</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Sie können die Erfassung Ihrer Daten durch Google Analytics verhindern, indem Sie auf
                            folgenden Link klicken. Es wird ein Opt-Out-Cookie gesetzt, der die Erfassung Ihrer Daten
                            bei zukünftigen Besuchen dieser Website verhindert:&nbsp;<a
                                href="javascript:gaOptout();">Google Analytics deaktivieren</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Mehr Informationen zum Umgang mit Nutzerdaten bei Google Analytics finden Sie in der
                            Datenschutzerklärung von Google:&nbsp;<a
                                href="https://support.google.com/analytics/answer/6004245?hl=de" target="_blank"
                                rel="noreferrer noopener">https://support.google.com/analytics/answer/6004245?hl=de</a>.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Auftragsverarbeitung</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir haben mit Google einen Vertrag zur Auftragsverarbeitung abgeschlossen und setzen die
                            strengen Vorgaben der deutschen Datenschutzbehörden bei der Nutzung von Google Analytics
                            vollständig um.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Demografische Merkmale bei Google Analytics</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Diese Website nutzt die Funktion „demografische Merkmale“ von Google Analytics. Dadurch
                            können Berichte erstellt werden, die Aussagen zu Alter, Geschlecht und Interessen der
                            Seitenbesucher enthalten. Diese Daten stammen aus interessenbezogener Werbung von Google
                            sowie aus Besucherdaten von Drittanbietern. Diese Daten können keiner bestimmten Person
                            zugeordnet werden. Sie können diese Funktion jederzeit über die Anzeigeneinstellungen in
                            Ihrem Google-Konto deaktivieren oder die Erfassung Ihrer Daten durch Google Analytics wie im
                            Punkt „Widerspruch gegen Datenerfassung“ dargestellt generell untersagen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Speicherdauer</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Bei Google gespeicherte Daten auf Nutzer- und Ereignisebene, die mit Cookies, Nutzerkennungen
                            (z.&nbsp;B. User ID) oder Werbe-IDs (z.&nbsp;B. DoubleClick-Cookies, Android-Werbe-ID)
                            verknüpft sind, werden nach 14 Monaten anonymisiert bzw. gelöscht. Details hierzu ersehen
                            Sie unter folgendem Link:&nbsp;<a
                                href="https://support.google.com/analytics/answer/7667196?hl=de" target="_blank"
                                rel="noreferrer noopener">https://support.google.com/analytics/answer/7667196?hl=de</a>
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Google Analytics Remarketing</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Unsere Websites nutzen die Funktionen von Google Analytics Remarketing in Verbindung mit den
                            geräteübergreifenden Funktionen von Google AdWords und Google DoubleClick. Anbieter ist die
                            Google Ireland Limited („Google“), Gordon House, Barrow Street, Dublin 4, Irland.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Diese Funktion ermöglicht es die mit Google Analytics Remarketing erstellten
                            Werbe-Zielgruppen mit den geräteübergreifenden Funktionen von Google AdWords und Google
                            DoubleClick zu verknüpfen. Auf diese Weise können interessenbezogene, personalisierte
                            Werbebotschaften, die in Abhängigkeit Ihres früheren Nutzungs- und Surfverhaltens auf einem
                            Endgerät (z.&nbsp;B. Handy) an Sie angepasst wurden auch auf einem anderen Ihrer Endgeräte
                            (z.&nbsp;B. Tablet oder PC) angezeigt werden.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Haben Sie eine entsprechende Einwilligung erteilt, verknüpft Google zu diesem Zweck Ihren
                            Web- und App-Browserverlauf mit Ihrem Google-Konto. Auf diese Weise können auf jedem
                            Endgerät auf dem Sie sich mit Ihrem Google-Konto anmelden, dieselben personalisierten
                            Werbebotschaften geschaltet werden.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Zur Unterstützung dieser Funktion erfasst Google Analytics google-authentifizierte IDs der
                            Nutzer, die vorübergehend mit unseren Google-Analytics-Daten verknüpft werden, um
                            Zielgruppen für die geräteübergreifende Anzeigenwerbung zu definieren und zu erstellen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sie können dem geräteübergreifenden Remarketing/Targeting dauerhaft widersprechen, indem Sie
                            personalisierte Werbung deaktivieren; folgen Sie hierzu diesem Link:&nbsp;<a
                                href="https://adssettings.google.com/anonymous?hl=de" target="_blank"
                                rel="noreferrer noopener">https://adssettings.google.com/</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Zusammenfassung der erfassten Daten in Ihrem Google-Konto erfolgt ausschließlich auf
                            Grundlage Ihrer Einwilligung, die Sie bei Google abgeben oder widerrufen können (Art. 6 Abs.
                            1 lit. a DSGVO). Bei Datenerfassungsvorgängen, die nicht in Ihrem Google-Konto
                            zusammengeführt werden (z.&nbsp;B. weil Sie kein Google-Konto haben oder der Zusammenführung
                            widersprochen haben) beruht die Erfassung der Daten auf Art. 6 Abs. 1 lit. f DSGVO. Das
                            berechtigte Interesse ergibt sich daraus, dass der Websitebetreiber ein Interesse an der
                            anonymisierten Analyse der Websitebesucher zu Werbezwecken hat.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Weitergehende Informationen und die Datenschutzbestimmungen finden Sie in der
                            Datenschutzerklärung von Google unter:&nbsp;<a
                                href="https://policies.google.com/technologies/ads?hl=de" target="_blank"
                                rel="noreferrer noopener">https://policies.google.com/technologies/ads?hl=de</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Google AdSense</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Diese Website benutzt Google AdSense, einen Dienst zum Einbinden von Werbeanzeigen der Google
                            Inc. (“Google”). Anbieter ist die Google Inc., 1600 Amphitheatre Parkway, Mountain View, CA
                            94043, USA. Google AdSense verwendet sogenannte “Cookies”, Textdateien, die auf Ihrem
                            Computer gespeichert werden und die eine Analyse der Benutzung der Website ermöglichen.
                            Google AdSense verwendet auch so genannte Web Beacons (unsichtbare Grafiken). Durch diese
                            Web Beacons können Informationen wie der Besucherverkehr auf diesen Seiten ausgewertet
                            werden. Die durch Cookies und Web Beacons erzeugten Informationen über die Benutzung dieser
                            Website (einschließlich Ihrer IP-Adresse) und Auslieferung von Werbeformaten werden an einen
                            Server von Google in den USA übertragen und dort gespeichert. Diese Informationen können von
                            Google an Vertragspartner von Google weiter gegeben werden. Google wird Ihre IP-Adresse
                            jedoch nicht mit anderen von Ihnen gespeicherten Daten zusammenführen. Die Speicherung von
                            AdSense-Cookies erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der Websitebetreiber
                            hat ein berechtigtes Interesse an der Analyse des Nutzerverhaltens, um sowohl sein
                            Webangebot als auch seine Werbung zu optimieren. Sie können die Installation der Cookies
                            durch eine entsprechende Einstellung Ihrer Browser Software verhindern; wir weisen Sie
                            jedoch darauf hin, dass Sie in diesem Fall gegebenenfalls nicht sämtliche Funktionen dieser
                            Website voll umfänglich nutzen können. Durch die Nutzung dieser Website erklären Sie sich
                            mit der Bearbeitung der über Sie erhobenen Daten durch Google in der zuvor beschriebenen Art
                            und Weise und zu dem zuvor benannten Zweck einverstanden.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Google AdWords und Google Conversion-Tracking</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Diese Website verwendet Google AdWords. AdWords ist ein Online-Werbeprogramm der Google
                            Ireland Limited („Google“), Gordon House, Barrow Street, Dublin 4, Irland.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Im Rahmen von Google AdWords nutzen wir das so genannte Conversion-Tracking. Wenn Sie auf
                            eine von Google geschaltete Anzeige klicken wird ein Cookie für das Conversion-Tracking
                            gesetzt. Bei Cookies handelt es sich um kleine Textdateien, die der Internet-Browser auf dem
                            Computer des Nutzers ablegt. Diese Cookies verlieren nach 30 Tagen ihre Gültigkeit und
                            dienen nicht der persönlichen Identifizierung der Nutzer. Besucht der Nutzer bestimmte
                            Seiten dieser Website und das Cookie ist noch nicht abgelaufen, können Google und wir
                            erkennen, dass der Nutzer auf die Anzeige geklickt hat und zu dieser Seite weitergeleitet
                            wurde.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Jeder Google AdWords-Kunde erhält ein anderes Cookie. Die Cookies können nicht über die
                            Websites von AdWords-Kunden nachverfolgt werden. Die mithilfe des Conversion-Cookies
                            eingeholten Informationen dienen dazu, Conversion-Statistiken für AdWords-Kunden zu
                            erstellen, die sich für Conversion-Tracking entschieden haben. Die Kunden erfahren die
                            Gesamtanzahl der Nutzer, die auf ihre Anzeige geklickt haben und zu einer mit einem
                            Conversion-Tracking-Tag versehenen Seite weitergeleitet wurden. Sie erhalten jedoch keine
                            Informationen, mit denen sich Nutzer persönlich identifizieren lassen. Wenn Sie nicht am
                            Tracking teilnehmen möchten, können Sie dieser Nutzung widersprechen, indem Sie das Cookie
                            des Google Conversion-Trackings über ihren Internet-Browser unter Nutzereinstellungen leicht
                            deaktivieren. Sie werden sodann nicht in die Conversion-Tracking Statistiken aufgenommen.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Speicherung von „Conversion-Cookies“ und die Nutzung dieses Tracking-Tools erfolgen auf
                            Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der Websitebetreiber hat ein berechtigtes
                            Interesse an der Analyse des Nutzerverhaltens, um sowohl sein Webangebot als auch seine
                            Werbung zu optimieren.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Mehr Informationen zu Google AdWords und Google Conversion-Tracking finden Sie in den
                            Datenschutzbestimmungen von Google:&nbsp;<a
                                href="https://policies.google.com/privacy?hl=de" target="_blank"
                                rel="noreferrer noopener">https://policies.google.com/privacy?hl=de</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sie können Ihren Browser so einstellen, dass Sie über das Setzen von Cookies informiert
                            werden und Cookies nur im Einzelfall erlauben, die Annahme von Cookies für bestimmte Fälle
                            oder generell ausschließen sowie das automatische Löschen der Cookies beim Schließen des
                            Browser aktivieren. Bei der Deaktivierung von Cookies kann die Funktionalität dieser Website
                            eingeschränkt sein.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>WordPress Stats</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Diese Website nutzt das WordPress Tool Stats, um Besucherzugriffe statistisch auszuwerten.
                            Anbieter ist die Automattic Inc., 60 29th Street #343, San Francisco, CA 94110-4929, USA.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>WordPress Stats verwendet Cookies, die auf Ihrem Computer gespeichert werden und die eine
                            Analyse der Benutzung der Website erlauben. Die durch die Cookies generierten Informationen
                            über die Benutzung unserer Website werden auf Servern in den USA gespeichert. Ihre
                            IP-Adresse wird nach der Verarbeitung und vor der Speicherung anonymisiert.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>„WordPress-Stats“-Cookies verbleiben auf Ihrem Endgerät, bis Sie sie löschen. Die Speicherung
                            von „WordPress Stats“-Cookies und die Nutzung dieses Analyse-Tools erfolgen auf Grundlage
                            von Art. 6 Abs. 1 lit. f DSGVO. Der Websitebetreiber hat ein berechtigtes Interesse an der
                            anonymisierten Analyse des Nutzerverhaltens, um sowohl sein Webangebot als auch seine
                            Werbung zu optimieren.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sie können Ihren Browser so einstellen, dass Sie über das Setzen von Cookies informiert
                            werden und Cookies nur im Einzelfall erlauben, die Annahme von Cookies für bestimmte Fälle
                            oder generell ausschließen sowie das automatische Löschen der Cookies beim Schließen des
                            Browser aktivieren. Bei der Deaktivierung von Cookies kann die Funktionalität unserer
                            Website eingeschränkt sein.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sie können der Erhebung und Nutzung Ihrer Daten für die Zukunft widersprechen, indem Sie mit
                            einem Klick auf diesen Link einen Opt-Out-Cookie in Ihrem Browser setzen:&nbsp;<a
                                href="https://www.quantcast.com/opt-out/" target="_blank"
                                rel="noreferrer noopener">https://www.quantcast.com/opt-out/</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie die Cookies auf Ihrem Rechner löschen, müssen Sie den Opt-Out-Cookie erneut setzen.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Meta-Pixel (ehemals Facebook Pixel)</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Diese Website nutzt zur Konversionsmessung der Besucheraktions-Pixel von Facebook/Meta.
                            Anbieter dieses Dienstes ist die Meta Platforms Ireland Limited, 4 Grand Canal Square,
                            Dublin 2, Irland. Die erfassten Daten werden nach Aussage von Facebook jedoch auch in die
                            USA und in andere Drittländer übertragen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>So kann das Verhalten der Seitenbesucher nachverfolgt werden, nachdem diese durch Klick auf
                            eine Facebook-Werbeanzeige auf die Website des Anbieters weitergeleitet wurden. Dadurch
                            können die Wirksamkeit der Facebook-Werbeanzeigen für statistische und Marktforschungszwecke
                            ausgewertet werden und zukünftige Werbemaßnahmen optimiert werden.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die erhobenen Daten sind für uns als Betreiber dieser Website anonym, wir können keine
                            Rückschlüsse auf die Identität der Nutzer ziehen. Die Daten werden aber von Facebook
                            gespeichert und verarbeitet, sodass eine Verbindung zum jeweiligen Nutzerprofil möglich ist
                            und Facebook die Daten für eigene Werbezwecke, entsprechend der
                            Facebook-Datenverwendungsrichtlinie&nbsp;<a
                                href="https://de-de.facebook.com/about/privacy/" target="_blank"
                                rel="noreferrer noopener">(https://de-de.facebook.com/about/privacy/)</a>&nbsp;verwenden
                            kann. Dadurch kann Facebook das Schalten von Werbeanzeigen auf Seiten von Facebook sowie
                            außerhalb von Facebook ermöglichen. Diese Verwendung der Daten kann von uns als
                            Seitenbetreiber nicht beeinflusst werden.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Nutzung dieses Dienstes erfolgt auf Grundlage Ihrer Einwilligung nach Art. 6 Abs. 1 lit.
                            a DSGVO und § 25 Abs. 1 TTDSG. Die Einwilligung ist jederzeit widerrufbar.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Soweit mit Hilfe des hier beschriebenen Tools personenbezogene Daten auf unserer Website
                            erfasst und an Facebook weitergeleitet werden, sind wir und die Meta Platforms Ireland
                            Limited, 4 Grand Canal Square, Grand Canal Harbour, Dublin 2, Irland gemeinsam für diese
                            Datenverarbeitung verantwortlich (Art. 26 DSGVO). Die gemeinsame Verantwortlichkeit
                            beschränkt sich dabei ausschließlich auf die Erfassung der Daten und deren Weitergabe an
                            Facebook. Die nach der Weiterleitung erfolgende Verarbeitung durch Facebook ist nicht Teil
                            der gemeinsamen Verantwortung. Die uns gemeinsam obliegenden Verpflichtungen wurden in einer
                            Vereinbarung über gemeinsame Verarbeitung festgehalten. Den Wortlaut der Vereinbarung finden
                            Sie unter:&nbsp;<a href="https://www.facebook.com/legal/controller_addendum"
                                target="_blank"
                                rel="noreferrer noopener">https://www.facebook.com/legal/controller_addendum</a>. Laut
                            dieser Vereinbarung sind wir für die Erteilung der Datenschutzinformationen beim Einsatz des
                            Facebook-Tools und für die datenschutzrechtlich sichere Implementierung des Tools auf
                            unserer Website verantwortlich. Für die Datensicherheit der Facebook-Produkte ist Facebook
                            verantwortlich. Betroffenenrechte (z. B. Auskunftsersuchen) hinsichtlich der bei Facebook
                            verarbeiteten Daten können Sie direkt bei Facebook geltend machen. Wenn Sie die
                            Betroffenenrechte bei uns geltend machen, sind wir verpflichtet, diese an Facebook
                            weiterzuleiten.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Datenübertragung in die USA wird auf die Standardvertragsklauseln der EU-Kommission
                            gestützt. Details finden Sie hier:&nbsp;<a
                                href="https://www.facebook.com/legal/EU_data_transfer_addendum" target="_blank"
                                rel="noreferrer noopener">https://www.facebook.com/legal/EU_data_transfer_addendum</a>&nbsp;und&nbsp;<a
                                href="https://de-de.facebook.com/help/566994660333381" target="_blank"
                                rel="noreferrer noopener">https://de-de.facebook.com/help/566994660333381</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>In den Datenschutzhinweisen von Facebook finden Sie weitere Hinweise zum Schutz Ihrer
                            Privatsphäre:&nbsp;<a href="https://de-de.facebook.com/about/privacy/" target="_blank"
                                rel="noreferrer noopener">https://de-de.facebook.com/about/privacy/</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sie können außerdem die Remarketing-Funktion „Custom Audiences” im Bereich Einstellungen für
                            Werbeanzeigen unter&nbsp;<a
                                href="https://www.facebook.com/ads/preferences/?entry_product=ad_settings_screen"
                                target="_blank"
                                rel="noreferrer noopener">https://www.facebook.com/ads/preferences/?entry_product=ad_settings_screen</a>&nbsp;deaktivieren.
                            Dazu müssen Sie bei Facebook angemeldet sein.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie kein Facebook Konto besitzen, können Sie nutzungsbasierte Werbung von Facebook auf
                            der Website der European Interactive Digital Advertising Alliance deaktivieren:&nbsp;<a
                                href="http://www.youronlinechoices.com/de/praferenzmanagement/" target="_blank"
                                rel="noreferrer noopener">http://www.youronlinechoices.com/de/praferenzmanagement/</a>.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":4} -->
                        <h4>Newsletter</h4>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie den auf der Website angebotenen Newsletter beziehen möchten, benötigen wir von Ihnen
                            eine E-Mail-Adresse sowie Informationen, welche uns die Überprüfung gestatten, dass Sie der
                            Inhaber der angegebenen E-Mail-Adresse sind und mit dem Empfang des Newsletters
                            einverstanden sind. Weitere Daten werden nicht bzw. nur auf freiwilliger Basis erhoben.
                            Diese Daten verwenden wir ausschließlich für den Versand der angeforderten Informationen und
                            geben diese nicht an Dritte weiter.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Verarbeitung der in das Newsletteranmeldeformular eingegebenen Daten erfolgt
                            ausschließlich auf Grundlage Ihrer Einwilligung (Art. 6 Abs. 1 lit. a DSGVO). Die erteilte
                            Einwilligung zur Speicherung der Daten, der E-Mail-Adresse sowie deren Nutzung zum Versand
                            des Newsletters können Sie jederzeit widerrufen, etwa über den „Austragen“-Link im
                            Newsletter. Die Rechtmäßigkeit der bereits erfolgten Datenverarbeitungsvorgänge bleibt vom
                            Widerruf unberührt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die von Ihnen zum Zwecke des Newsletter-Bezugs bei uns hinterlegten Daten werden von uns bis
                            zu Ihrer Austragung aus dem Newsletter gespeichert und nach der Abbestellung des Newsletters
                            gelöscht. Daten, die zu anderen Zwecken bei uns gespeichert wurden bleiben hiervon
                            unberührt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":4} -->
                        <h4>Eigene Dienste</h4>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Bewerbungen</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Senden Sie uns eine Bewerbung, verarbeiten wir Ihre dort angegebenen personenbezogenen Daten,
                            um Ihre Bewerbung zu bearbeiten und mit Ihnen Kontakt aufzunehmen. Die Sie betreffenden
                            personenbezogenen Daten werden ohne Ihre ausdrückliche Zustimmung nicht an Dritte
                            weitergegeben, es sei denn, wir sind gesetzlich dazu verpflichtet, Sie haben dies gewünscht
                            oder die Datenweitergabe ist zur Anbahnung und Durchführung eines Vertragsverhältnisses mit
                            Ihnen oder des Bewerbungsverfahrens erforderlich. Rechtsgrundlage ist Artikel 6 Absatz 1
                            Unterabsatz 1 Buchstabe a, b DSGVO, Artikel 88 Absatz 1 DSGVO, § 26 Absatz 1
                            Bundesdatenschutzgesetz (BDSG).</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Bewerbungen löschen wir spätestens drei Monate nach Abschluss des Bewerbungsverfahrens.
                            Sollten die Daten nach Abschluss des Bewerbungsverfahrens ggf. zur Rechtsverfolgung
                            erforderlich sein, kann eine Datenverarbeitung auf Basis der Voraussetzungen von Artikel 6
                            DSGVO, insbesondere zur Wahrnehmung von berechtigten Interessen nach Artikel 6 Absatz 1
                            Unterabsatz 1 Buchstabe f DSGVO erfolgen. Unser berechtigtes Interesse besteht dann in der
                            Geltendmachung oder Abwehr von Ansprüchen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Ist Ihre Bewerbung erfolgreich, verarbeiten wir die Sie betreffenden personenbezogenen Daten
                            für die Zwecke des Beschäftigungsverhältnisses weiter.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Haben Sie ausdrücklich eine Einwilligung erteilt, können Sie Ihre Einwilligungserklärung
                            jederzeit mit Wirkung für die Zukunft widerrufen, so dass wir Ihre Daten löschen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Umfang und Zweck der Datenerhebung</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie uns eine Bewerbung zukommen lassen, verarbeiten wir Ihre damit verbundenen
                            personenbezogenen Daten (z.&nbsp;B. Kontakt- und Kommunikationsdaten, Bewerbungsunterlagen,
                            Notizen im Rahmen von Bewerbungsgesprächen etc.), soweit dies zur Entscheidung über die
                            Begründung eines Beschäftigungsverhältnisses erforderlich ist. Rechtsgrundlage hierfür ist §
                            26 BDSG-neu nach deutschem Recht (Anbahnung eines Beschäftigungsverhältnisses), Art. 6 Abs.
                            1 lit. b DSGVO (allgemeine Vertragsanbahnung) und – sofern Sie eine Einwilligung erteilt
                            haben – Art. 6 Abs. 1 lit. a DSGVO. Die Einwilligung ist jederzeit widerrufbar. Ihre
                            personenbezogenen Daten werden innerhalb unseres Unternehmens ausschließlich an Personen
                            weitergegeben, die an der Bearbeitung Ihrer Bewerbung beteiligt sind.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sofern die Bewerbung erfolgreich ist, werden die von Ihnen eingereichten Daten auf Grundlage
                            von § 26 BDSG-neu und Art. 6 Abs. 1 lit. b DSGVO zum Zwecke der Durchführung des
                            Beschäftigungsverhältnisses in unseren Datenverarbeitungssystemen gespeichert.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Dauer der Speicherung</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Gespeicherte Server-Logfiles und IP-Adressen werden spätestens nach sieben Tagen gelöscht.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Session-Cookies werden nach Beendigung der Sitzung automatisch gelöscht. Andere Cookies
                            werden auf Ihrem Endgerät gespeichert, und Sie haben die Kontrolle über die Verwendung und
                            Löschung von Cookies, s.o.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Ihre Daten aus Ihren Anfragen via E-Mail oder via Kontaktformular verarbeiten wir, bis Ihre
                            Anfrage vollständig bearbeitet und erledigt ist. Danach werden die Angaben gelöscht. Bitte
                            beachten Sie aber, dass wegen eines Rechtsgeschäfts mit Ihnen für bestimmte Daten handels-
                            und steuerrechtliche Aufbewahrungspflichten von mindestens sechs (§ 257 HGB) oder zehn (§147
                            AO) Jahren bestehen können, was auch für den Inhalt von Kontaktanfragen und E-Mails gelten
                            kann, s.o.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Bewerben Sie sich etwa via E-Mail, löschen wir Ihre übermittelten personenbezogenen Daten und
                            Bewerbungen drei Monate nach Abschluss des Bewerbungsverfahrens. Ist Ihre Bewerbung
                            erfolgreich, verarbeiten wir Ihre personenbezogenen Daten für die Zwecke des
                            Beschäftigungsverhältnisses weiter. Haben Sie ausdrücklich eine Einwilligung erteilt, können
                            Sie Ihre Einwilligungserklärung jederzeit mit Wirkung für die Zukunft widerrufen, so dass
                            wir Ihre Daten löschen, s.o.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Im Übrigen wird im jährlichen Turnus geprüft, ob eine Löschung von Daten erfolgen kann. Dies
                            ist der Fall, wenn der Verarbeitungszweck und die Voraussetzungen der Rechtsgrundlage für
                            die Verarbeitung entfallen sind und keine gesetzliche Verpflichtung zur Aufbewahrung
                            existiert.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":4} -->
                        <h4>Online Marketing und Partnerprogramme</h4>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Amazon Partnerprogramm</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Die Betreiber der Seiten nehmen am Amazon EU- Partnerprogramm teil. Auf unseren Seiten werden
                            durch Amazon Werbeanzeigen und Links zur Seite von Amazon.de eingebunden, an denen wir über
                            23 / 27 Werbekostenerstattung Geld verdienen können. Amazon setzt dazu Cookies ein, um die
                            Herkunft der Bestellungen nachvollziehen zu können. Dadurch kann Amazon erkennen, dass Sie
                            den Partnerlink auf unserer Website geklickt haben. Die Speicherung von „Amazon-Cookies“
                            erfolgt auf Grundlage von Art. 6 lit. f DSGVO. Der Websitebetreiber hat hieran ein
                            berechtigtes Interesse, da nur durch die Cookies die Höhe seiner Affiliate-Vergütung
                            feststellbar ist. Weitere Informationen zur Datennutzung durch Amazon erhalten Sie in der
                            Datenschutzerklärung von Amazon:&nbsp;<a
                                href="https://www.amazon.de/gp/help/customer/display.html/ref=footer_privacy?ie=UTF8&amp;nodeId=3312401"
                                rel="noreferrer noopener"
                                target="_blank">https://www.amazon.de/gp/help/customer/display.html/ref=footer_privacy?ie=UTF8&amp;nodeId=3312401</a>.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":4} -->
                        <h4>Zahlungsanbieter und Reseller</h4>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":5} -->
                        <h5>PayPal</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Auf unserer Website bieten wir u.a. die Bezahlung via PayPal an. Anbieter dieses
                            Zahlungsdienstes ist die PayPal (Europe) S.à.r.l. et Cie, S.C.A., 22-24 Boulevard Royal,
                            L-2449 Luxembourg (im Folgenden „PayPal“).</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie die Bezahlung via PayPal auswählen, werden die von Ihnen eingegebenen Zahlungsdaten
                            an PayPal übermittelt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Übermittlung Ihrer Daten an PayPal erfolgt auf Grundlage von Art. 6 Abs. 1 lit. a DSGVO
                            (Einwilligung) und Art. 6 Abs. 1 lit. b DSGVO (Verarbeitung zur Erfüllung eines Vertrags).
                            Sie haben die Möglichkeit, Ihre Einwilligung zur Datenverarbeitung jederzeit zu widerrufen.
                            Ein Widerruf wirkt sich auf die Wirksamkeit von in der Vergangenheit liegenden
                            Datenverarbeitungsvorgängen nicht aus.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Klarna</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Auf unserer Website bieten wir u.a. die Bezahlung mit den Diensten von Klarna an. Anbieter
                            ist die Klarna AB, Sveavägen 46, 111 34 Stockholm, Schweden (im Folgenden „Klarna“).</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Klarna bietet verschiedene Zahlungsoptionen an (z.&nbsp;B. Ratenkauf). Wenn Sie sich für die
                            Bezahlung mit Klarna entscheiden (Klarna-Checkout-Lösung), wird Klarna verschiedene
                            personenbezogene Daten von Ihnen erheben. Details hierzu können Sie in der
                            Datenschutzerklärung von Klarna unter folgendem Link nachlesen:&nbsp;<a
                                href="https://www.klarna.com/de/datenschutz/" target="_blank"
                                rel="noreferrer noopener">https://www.klarna.com/de/datenschutz/</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Klarna nutzt Cookies, um die Verwendung der Klarna-Checkout-Lösung zu optimieren. Die
                            Optimierung der Checkout-Lösung stellt ein berechtigtes Interesse im Sinne von Art. 6 Abs. 1
                            lit. f DSGVO dar. Cookies sind kleine Textdateien, die auf Ihrem Endgerät gespeichert werden
                            und keinen Schaden anrichten. Sie verbleiben auf Ihrem Endgerät bis Sie sie löschen. Details
                            zum Einsatz von Klarna-Cookies entnehmen Sie folgendem Link:&nbsp;<a
                                href="https://cdn.klarna.com/1.0/shared/content/policy/cookie/de_de/checkout.pdf"
                                target="_blank"
                                rel="noreferrer noopener">https://cdn.klarna.com/1.0/shared/content/policy/cookie/de_de/checkout.pdf</a>.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Übermittlung Ihrer Daten an Klarna erfolgt auf Grundlage von Art. 6 Abs. 1 lit. a DSGVO
                            (Einwilligung) und Art. 6 Abs. 1 lit. b DSGVO (Verarbeitung zur Erfüllung eines Vertrags).
                            Sie haben die Möglichkeit, Ihre Einwilligung zur Datenverarbeitung jederzeit zu widerrufen.
                            Ein Widerruf wirkt sich auf die Wirksamkeit von in der Vergangenheit liegenden
                            Datenverarbeitungsvorgängen nicht aus.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Sofortüberweisung</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Auf unserer Website bieten wir u.a. die Bezahlung mittels „Sofortüberweisung“ an. Anbieter
                            dieses Zahlungsdienstes ist die Sofort GmbH, Theresienhöhe 12, 80339 München (im Folgenden
                            „Sofort GmbH“).</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Mit Hilfe des Verfahrens „Sofortüberweisung“ erhalten wir in Echtzeit eine
                            Zahlungsbestätigung von der Sofort GmbH und können unverzüglich mit der Erfüllung unserer
                            Verbindlichkeiten beginnen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie sich für die Zahlungsart „Sofortüberweisung“ entschieden haben, übermitteln Sie die
                            PIN und eine gültige TAN an die Sofort GmbH, mit der diese sich in Ihr Online-Banking-Konto
                            einloggen kann. Sofort GmbH überprüft nach dem Einloggen automatisch Ihren Kontostand und
                            führt die Überweisung an uns mit Hilfe der von Ihnen übermittelten TAN durch. Anschließend
                            übermittelt sie uns unverzüglich eine Transaktionsbestätigung. Nach dem Einloggen werden
                            außerdem Ihre Umsätze, der Kreditrahmen des Dispokredits und das Vorhandensein anderer
                            Konten sowie deren Bestände automatisiert geprüft.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Neben der PIN und der TAN werden auch die von Ihnen eingegebenen Zahlungsdaten sowie Daten zu
                            Ihrer Person an die Sofort GmbH übermittelt. Bei den Daten zu Ihrer Person handelt es sich
                            um Vor- und Nachname, Adresse, Telefonnummer(n), Email-Adresse, IP-Adresse und ggf. weitere
                            zur Zahlungsabwicklung erforderliche Daten. Die Übermittlung dieser Daten ist notwendig, um
                            Ihre Identität zweifelsfrei zu festzustellen und Betrugsversuchen vorzubeugen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Übermittlung Ihrer Daten an die Sofort GmbH erfolgt auf Grundlage von Art. 6 Abs. 1 lit.
                            a DSGVO (Einwilligung) und Art. 6 Abs. 1 lit. b DSGVO (Verarbeitung zur Erfüllung eines
                            Vertrags). Sie haben die Möglichkeit, Ihre Einwilligung zur Datenverarbeitung jederzeit zu
                            widerrufen. Ein Widerruf wirkt sich auf die Wirksamkeit von in der Vergangenheit liegenden
                            Datenverarbeitungsvorgängen nicht aus.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Details zur Zahlung mit Sofortüberweisung entnehmen Sie folgenden Links:&nbsp;<a
                                href="https://www.sofort.de/datenschutz.html" target="_blank"
                                rel="noreferrer noopener">https://www.sofort.de/datenschutz.html</a>&nbsp;und&nbsp;<a
                                href="https://www.klarna.com/sofort/" target="_blank"
                                rel="noreferrer noopener">https://www.klarna.com/sofort/</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Paydirekt</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Auf unserer Website bieten wir u.a. die Bezahlung mittels Paydirekt an. Anbieter dieses
                            Zahlungsdienstes ist die Paydirekt GmbH, Hamburger Allee 26-28, 60486 Frankfurt am Main,
                            Deutschland (im Folgenden „Paydirekt“).</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie die Bezahlung mittels Paydirekt ausführen, erhebt Paydirekt verschiedene
                            Transaktionsdaten und leitet diese an die Bank weiter, bei der Sie mit Paydirekt registriert
                            sind. Neben den für die Zahlung erforderlichen Daten erhebt Paydirekt im Rahmen der
                            Transaktionsabwicklung ggf. weitere Daten wie z.&nbsp;B. Lieferadresse oder einzelne
                            Positionen im Warenkorb.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Paydirekt authentifiziert die Transaktion anschließend mit Hilfe des bei der Bank hierfür
                            hinterlegten Authentifizierungsverfahrens. Anschließend wird der Zahlbetrag von Ihrem Konto
                            auf unser Konto überwiesen. Weder wir noch Dritte haben Zugriff auf Ihre Kontodaten.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Details zur Zahlung mit Paydirekt entnehmen Sie den AGB und den Datenschutzbestimmungen von
                            Paydirekt unter:&nbsp;<a href="https://www.paydirekt.de/agb/index.html" target="_blank"
                                rel="noreferrer noopener">https://www.paydirekt.de/agb/index.html</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":4} -->
                        <h4>Unsere Social–Media–Auftritte</h4>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Datenverarbeitung durch soziale Netzwerke</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir unterhalten öffentlich zugängliche Profile in sozialen Netzwerken. Die im Einzelnen von
                            uns genutzten sozialen Netzwerke finden Sie weiter unten.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Soziale Netzwerke wie Facebook, Google+ etc. können Ihr Nutzerverhalten in der Regel
                            umfassend analysieren, wenn Sie deren Webseite oder eine Webseite mit integrierten
                            Social-Media-Inhalten (z.&nbsp;B. Like-Buttons oder Werbebannern) besuchen. Durch den Besuch
                            unserer Social-Media-Präsenzen werden zahlreiche datenschutzrelevante Verarbeitungsvorgänge
                            ausgelöst. Im Einzelnen:</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie in Ihrem Social-Media-Account eingeloggt sind und unsere Social-Media-Präsenz
                            besuchen, kann der Betreiber des Social-Media-Portals diesen Besuch Ihrem Benutzerkonto
                            zuordnen. Ihre personenbezogenen Daten können unter Umständen aber auch dann erfasst werden,
                            wenn Sie nicht eingeloggt sind oder keinen Account beim jeweiligen Social-Media-Portal
                            besitzen. Diese Datenerfassung erfolgt in diesem Fall beispielsweise über Cookies, die auf
                            Ihrem Endgerät gespeichert werden oder durch Erfassung Ihrer IP-Adresse.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Mit Hilfe der so erfassten Daten können die Betreiber der Social-Media-Portale Nutzerprofile
                            erstellen, in denen Ihre Präferenzen und Interessen hinterlegt sind. Auf diese Weise kann
                            Ihnen interessenbezogene Werbung in- und außerhalb der jeweiligen Social-Media-Präsenz
                            angezeigt werden. Sofern Sie über einen Account beim jeweiligen sozialen Netzwerk verfügen,
                            kann die interessenbezogene Werbung auf allen Geräten angezeigt werden, auf denen Sie
                            eingeloggt sind oder eingeloggt waren.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Bitte beachten Sie außerdem, dass wir nicht alle Verarbeitungsprozesse auf den
                            Social-Media-Portalen nachvollziehen können. Je nach Anbieter können daher ggf. weitere
                            Verarbeitungsvorgänge von den Betreibern der Social-Media-Portale durchgeführt werden.
                            Details hierzu entnehmen Sie den Nutzungsbedingungen und Datenschutzbestimmungen der
                            jeweiligen Social-Media-Portale.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><strong>Rechtsgrundlage</strong><br>Unsere Social-Media-Auftritte sollen eine möglichst
                            umfassende Präsenz im Internet gewährleisten. Hierbei handelt es sich um ein berechtigtes
                            Interesse im Sinne von Art. 6 Abs. 1 lit. f DSGVO. Die von den sozialen Netzwerken
                            initiierten Analyseprozesse beruhen ggf. auf abweichenden Rechtsgrundlagen, die von den
                            Betreibern der sozialen Netzwerke anzugeben sind (z.&nbsp;B. Einwilligung im Sinne des Art.
                            6 Abs. 1 lit. a DSGVO).</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><strong>Verantwortlicher und Geltendmachung von Rechten</strong><br>Wenn Sie einen unserer
                            Social-Media-Auftritte (z.&nbsp;B. Facebook) besuchen, sind wir gemeinsam mit dem Betreiber
                            der Social-Media-Plattform für die bei diesem Besuch ausgelösten Datenverarbeitungsvorgänge
                            verantwortlich. Sie können Ihre Rechte (Auskunft, Berichtigung, Löschung, Einschränkung der
                            Verarbeitung, Datenübertragbarkeit und Beschwerde) grundsätzlich sowohl ggü. uns als auch
                            ggü. dem Betreiber des jeweiligen Social-Media-Portals (z.&nbsp;B. ggü. Facebook) geltend
                            machen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Bitte beachten Sie, dass wir trotz der gemeinsamen Verantwortlichkeit mit den
                            Social-Media-Portal-Betreibern nicht vollumfänglich Einfluss auf die
                            Datenverarbeitungsvorgänge der Social-Media-Portale haben. Unsere Möglichkeiten richten sich
                            maßgeblich nach der Unternehmenspolitik des jeweiligen Anbieters.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><strong>Speicherdauer</strong><br>Die unmittelbar von uns über die Social-Media-Präsenz
                            erfassten Daten werden von unseren Systemen gelöscht, sobald der Zweck für ihre Speicherung
                            entfällt, Sie uns zur Löschung auffordern, Ihre Einwilligung zur Speicherung widerrufen oder
                            der Zweck für die Datenspeicherung entfällt. Gespeicherte Cookies verbleiben auf Ihrem
                            Endgerät, bis Sie sie löschen. Zwingende gesetzliche Bestimmungen – insb.
                            Aufbewahrungsfristen – bleiben unberührt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Auf die Speicherdauer Ihrer Daten, die von den Betreibern der sozialen Netzwerke zu eigenen
                            Zwecken gespeichert werden, haben wir keinen Einfluss. Für Einzelheiten dazu informieren Sie
                            sich bitte direkt bei den Betreibern der sozialen Netzwerke (z.&nbsp;B. in deren
                            Datenschutzerklärung, siehe unten).</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Soziale Netzwerke im Einzelnen</h5>
                        <!-- /wp:heading -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Facebook</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir verfügen über ein Profil bei Facebook. Anbieter ist die Facebook Inc., 1 Hacker Way,
                            Menlo Park, California 94025, USA. Facebook verfügt über eine Zertifizierung nach dem
                            EU-US-Privacy-Shield.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wir haben mit Facebook eine Vereinbarung über gemeinsame Verarbeitung (Controller Addendum)
                            geschlossen. In dieser Vereinbarung wird festgelegt, für welche Datenverarbeitungsvorgänge
                            wir bzw. Facebook verantwortlich ist, wenn Sie unsere Facebook-Page besuchen. Diese
                            Vereinbarung können Sie unter folgendem Link einsehen:&nbsp;<a
                                href="https://www.facebook.com/legal/terms/page_controller_addendum" target="_blank"
                                rel="noreferrer noopener">https://www.facebook.com/legal/terms/page_controller_addendum</a>.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><strong>Sie können Ihre Werbeeinstellungen selbstständig in Ihrem Nutzer-Account anpassen.
                                Klicken Sie hierzu auf folgenden Link und loggen Sie sich ein:</strong><a
                                href="https://www.facebook.com/settings?tab=ads" target="_blank"
                                rel="noreferrer noopener">https://www.facebook.com/settings?tab=ads</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Details entnehmen Sie der Datenschutzerklärung von Facebook:&nbsp;<a
                                href="https://www.facebook.com/about/privacy/" target="_blank"
                                rel="noreferrer noopener">https://www.facebook.com/about/privacy/</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":6} -->
                        <h6>Facebook-Fanpage Insights – Hinweis für unsere Facebook-Fanpage Nutzer</h6>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Facebook Ireland Ltd („Facebook“) stellt uns als Facebook-Fanpage Betreiber sog.
                            „Facebook-Insights“ („Insights“) zur Verfügung. Bei den Insights handelt es sich um
                            verschiedene Statistiken, die uns Aufschluss über die Verwendung unserer Facebook-Fanpage
                            geben. Detaillierte Informationen hierzu und welche Datenverarbeitung stattfindet, finden
                            Sie unter&nbsp;<a href="https://www.facebook.com/business/a/page/page-insights"
                                target="_blank"
                                rel="noreferrer noopener">https://www.facebook.com/business/a/page/page-insights</a>&nbsp;sowie&nbsp;<a
                                href="https://www.facebook.com/legal/terms/information_about_page_insights_data"
                                target="_blank"
                                rel="noreferrer noopener">https://www.facebook.com/legal/terms/information_about_page_insights_data</a>
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Facebook-Fanpage-Insights können auf personenbezogenen Daten basieren, die im Zusammenhang
                            mit einem Besuch oder einer Interaktion von Personen auf bzw. mit unserer Facebook-Fanpage
                            und ihren Inhalten erfasst wurden, so dass auch personenbezogene Daten durch Facebook
                            verarbeitet werden können, besuchen Sie unsere Facebook-Site. Die wesentlichen Informationen
                            der zwischen uns und Facebook geschlossenen Vereinbarung im Sinne von Artikel 26
                            Datenschutz-Grundverordnung finden Sie dort:&nbsp;<a
                                href="https://www.facebook.com/legal/terms/page_controller_addendum" target="_blank"
                                rel="noreferrer noopener">https://www.facebook.com/legal/terms/page_controller_addendum</a>
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><strong>Gemeinsam für die Verarbeitung verantwortlich</strong>&nbsp;Facebook-Fanpage Insights
                            sind</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Facebook Ireland Ltd.<br>4 Grand Canal Square<br>Grand Canal Harbour<br>Dublin 2,
                            Ireland<br><a href="https://www.facebook.com/business/gdpr" target="_blank"
                                rel="noreferrer noopener">https://www.facebook.com/business/gdpr</a><br><a
                                href="https://www.facebook.com/help/contact/540977946302970" target="_blank"
                                rel="noreferrer noopener">https://www.facebook.com/help/contact/540977946302970</a></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>und</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Zahnarztordination Dr. Saif Al-Zahrooni, MSc (Kieferorthopädie) Ringstraße 38d, 3500 Krems an
                            der Donau 3500 02732 82828&nbsp;<a
                                href="mailto:info@zahnspangehome.at">info@zahnspangehome.at</a></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Facebook Ireland erfüllt hierbei primär:</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:list -->
                        <ul>
                            <!-- wp:list-item -->
                            <li>die Informationspflichten aus Artikeln 12, 13 DSGVO, ebenso</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>die Verpflichtungen aus Artikel 15 bis 21 DSGVO, die Betroffenenrechte können also
                                gegenüber Facebook Ireland geltend gemacht werden, sowie</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>die Pflichten aus Artikel 33 und 34 DSGVO.</li>
                            <!-- /wp:list-item -->
                        </ul>
                        <!-- /wp:list -->

                        <!-- wp:paragraph -->
                        <p>Selbstverständlich können Sie Ihre Rechte aber auch uns gegenüber geltend machen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Facebook Ireland trifft im Einklang mit Artikel 32 DSGVO geeignete technische und
                            organisatorische Maßnahmen, um die Sicherheit der Verarbeitungen mittels Facebook Fanpage
                            Insights zu gewährleisten.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Rechtsgrundlage und Zwecke der Verarbeitung seitens Facebook Ireland entnehmen Sie bitte den
                            dortigen Angaben:&nbsp;<a href="https://www.facebook.com/about/privacy/legal_bases"
                                target="_blank"
                                rel="noreferrer noopener">https://www.facebook.com/about/privacy/legal_bases</a>&nbsp;und&nbsp;<a
                                href="https://www.facebook.com/policy.php" target="_blank"
                                rel="noreferrer noopener">https://www.facebook.com/policy.php</a></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wir verarbeiten die Facebook Fanpage Insights Daten aufgrund unseres berechtigen Interesse
                            zur Auswertungen der Aktivitäten auf unserer Fanpage und unserer Marketingmaßnahmen dort
                            (Werbeanzeigen, -Kampagnen, -Postings); Artikel 6 Absatz 1 Satz 1 f) DSGVO.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Weitere Informationen: Datenschutz:&nbsp;<a
                                href="https://www.itmr-legal.de/datenschutz-facebook-fanpages-insights/"
                                target="_blank" rel="noreferrer noopener">Facebook Fanpages und InSights – hier die
                                Antworten</a></p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sie sind gesetzlich nicht verpflichtet, Ihre personenbezogenen Daten bereitzustellen. Die
                            Bereitstellung kann jedoch für einen Vertragsabschluss oder für Funktionen der Facebook
                            Fanpage erforderlich sein. Bei einer Nichtbereitstellung kann also gegebenenfalls ein
                            Vertrag oder eine Funktion auf der Facebook Fanpage nicht angeboten werden.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Die Rechte von betroffenen Personen ergeben sich insbesondere aus Artikel 15 bis 23 und
                            Artikel 77 Datenschutzgrundverordnung sowie aus §§ 32 bis 37 Bundesdatenschutzgesetz.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sie haben im Hinblick auf Ihre personenbezogenen Daten das Recht auf</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:list -->
                        <ul>
                            <!-- wp:list-item -->
                            <li>Auskunft, Artikel 15 Datenschutzgrundverordnung</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Berichtigung, Artikel 16 Datenschutzgrundverordnung</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Löschung, Artikel 17 Datenschutzgrundverordnung</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Einschränkung der Verarbeitung, Artikel 18 Datenschutzgrundverordnung und</li>
                            <!-- /wp:list-item -->

                            <!-- wp:list-item -->
                            <li>Übertragbarkeit, Artikel 20 Datenschutzgrundverordnung.</li>
                            <!-- /wp:list-item -->
                        </ul>
                        <!-- /wp:list -->

                        <!-- wp:paragraph -->
                        <p>Sie haben ferner das Recht, gegen die Verarbeitung von personenbezogenen Daten</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:list -->
                        <ul>
                            <!-- wp:list-item -->
                            <li>Widerspruch, Artikel 21 Datenschutzgrundverordnung</li>
                            <!-- /wp:list-item -->
                        </ul>
                        <!-- /wp:list -->

                        <!-- wp:paragraph -->
                        <p>zu erheben, siehe weitere Informationen gesondert sogleich.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Wenn Sie eine Einwilligung zur Verarbeitung von personenbezogenen Daten erteilt haben, haben
                            Sie das Recht des</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:list -->
                        <ul>
                            <!-- wp:list-item -->
                            <li>Widerrufs, Artikel 7 Datenschutzgrundverordnung</li>
                            <!-- /wp:list-item -->
                        </ul>
                        <!-- /wp:list -->

                        <!-- wp:paragraph -->
                        <p>mit Wirkung für die Zukunft.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Alle Anfragen, Aufforderungen und Mitteilungen richten Sie bitte an Facebook Ireland oder an
                            uns, siehe oben-</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Sind Sie der Ansicht, dass die Verarbeitung der Sie betreffenden personenbezogenen Daten
                            gegen das Datenschutzrecht verstößt, haben Sie stets das</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:list -->
                        <ul>
                            <!-- wp:list-item -->
                            <li>Recht auf Beschwerde</li>
                            <!-- /wp:list-item -->
                        </ul>
                        <!-- /wp:list -->

                        <!-- wp:paragraph -->
                        <p>bei der zuständigen Aufsichtsbehörde, vgl. Artikel 77 Datenschutzgrundverordnung. Unbeschadet
                            eines anderweitigen verwaltungsrechtlichen oder gerichtlichen Rechtsbehelfs steht Ihnen
                            dieses Recht auf Beschwerde bei einer Aufsichtsbehörde, insbesondere in dem Mitgliedstaat
                            Ihres Aufenthaltsorts, Ihres Arbeitsplatzes oder des Orts des mutmaßlichen Verstoßes zu,
                            wenn Sie der Ansicht sind, dass die Verarbeitung der Sie betreffenden personenbezogenen
                            Daten gegen die Datenschutzgrundverordnung verstößt. Die für Facebook Ireland zuständige
                            Aufsichtsbehörde ist die irische Datenschutzkommission (<a
                                href="https://www.dataprotection.ie/" target="_blank"
                                rel="noreferrer noopener">https://www.dataprotection.ie/</a>) für uns ist zuständig die
                            Landesbeauftragte für Datenschutz und Informationsfreiheit Nordrhein-Westfalen,
                            Kavalleriestraße 2-4, 40213 Düsseldorf.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>INFORMATIONEN ÜBER IHR WIDERSPRUCHSRECHT NACH ARTIKEL 21 DSGVO</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>1. Sie haben das Recht aus Gründen, die sich aus Ihrer besonderen Situation ergeben,
                            jederzeit gegen die Verarbeitung Sie betreffender personenbezogener Daten Widerspruch
                            einzulegen, die aufgrund von Artikel 6 Absatz 1 Satz 1 f) Datenschutzgrundverordnung
                            (Datenverarbeitung auf der Grundlage einer Interessenabwägung) erfolgt.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Legen Sie Widerspruch ein, werden wir Ihre personenbezogenen Daten nicht mehr verarbeiten, es
                            sei denn, wir können zwingende schutzwürdige Gründe für die Verarbeitung nachweisen, die
                            Ihre Interessen, Rechte und Freiheiten überwiegen, oder die Verarbeitung dient der
                            Geltendmachung, Ausübung oder Verteidigung von Rechtsansprüchen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>2. In Einzelfällen verarbeiten wir personenbezogene Daten, um Direktwerbung zu betreiben. Ist
                            dies bei Ihnen der Fall, haben Sie das Recht, jederzeit Widerspruch gegen die Verarbeitung
                            Sie betreffender Daten zum Zwecke derartiger Werbung einzulegen</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Widersprechen Sie der Verarbeitung für Zwecke der Direktwerbung, so werden wir Ihre
                            personenbezogenen Daten nicht mehr für diese Zwecke verarbeiten.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Der Widerspruch kann formfrei erfolgen.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Google+</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir verfügen über ein Profil bei Google+. Anbieter ist die Google Ireland Limited („Google“),
                            Gordon House, Barrow Street, Dublin 4, Irland. Google verfügt über eine Zertifizierung nach
                            dem EU-US-Privacy-Shield:</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><strong>Sie können Ihre Werbeeinstellungen selbstständig in Ihrem Nutzer-Account anpassen.
                                Klicken Sie hierzu auf folgenden Link und loggen Sie sich ein:</strong>&nbsp;<a
                                href="https://adssettings.google.com/authenticated" target="_blank"
                                rel="noreferrer noopener">https://adssettings.google.com/authenticated</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Details entnehmen Sie der Datenschutzerklärung von Google:&nbsp;<a
                                href="https://policies.google.com/privacy" target="_blank"
                                rel="noreferrer noopener">https://policies.google.com/privacy</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Twitter</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir nutzen den Kurznachrichtendienst Twitter. Anbieter ist die Twitter Inc., 1355 Market
                            Street, Suite 900, San Francisco, CA 94103, USA. Twitter verfügt über eine Zertifizierung
                            nach dem EU-US-Privacy-Shield.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><strong>Sie können Ihre Twitter-Datenschutzeinstellungen selbstständig in Ihrem
                                Nutzer-Account anpassen. Klicken Sie hierzu auf folgenden Link und loggen Sie sich
                                ein:</strong>&nbsp;<a href="https://twitter.com/personalization" target="_blank"
                                rel="noreferrer noopener">https://twitter.com/personalization</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Details entnehmen Sie der Datenschutzerklärung von Twitter:&nbsp;<a
                                href="https://twitter.com/de/privacy" target="_blank"
                                rel="noreferrer noopener">https://twitter.com/de/privacy</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Instagram</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir verfügen über ein Profil bei Instagram. Anbieter ist die Instagram Inc., 1601 Willow
                            Road, Menlo Park, CA, 94025, USA. Details zu deren Umgang mit Ihren personenbezogenen Daten
                            entnehmen Sie der Datenschutzerklärung von Instagram:&nbsp;<a
                                href="https://help.instagram.com/519522125107875" target="_blank"
                                rel="noreferrer noopener">https://help.instagram.com/519522125107875</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Pinterest</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir verfügen über ein Profil bei Pinterest. Betreiber ist die Pinterest Inc., 808 Brannan
                            Street San Francisco, CA 94103-490, USA („Pinterest“). Details zu deren Umgang mit Ihren
                            personenbezogenen Daten entnehmen Sie der Datenschutzerklärung von Pinterest:&nbsp;<a
                                href="https://policy.pinterest.com/de/privacy-policy" target="_blank"
                                rel="noreferrer noopener">https://policy.pinterest.com/de/privacy-policy</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>XING</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir verfügen über ein Profil bei XING. Anbieter ist die XING AG, Dammtorstraße 29-32, 20354
                            Hamburg, Deutschland. Details zu deren Umgang mit Ihren personenbezogenen Daten entnehmen
                            Sie der Datenschutzerklärung von XING:&nbsp;<a
                                href="https://privacy.xing.com/de/datenschutzerklaerung" target="_blank"
                                rel="noreferrer noopener">https://privacy.xing.com/de/datenschutzerklaerung</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>LinkedIn</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir verfügen über ein Profil bei LinkedIn. Anbieter ist die LinkedIn Ireland Unlimited
                            Company<strong>,&nbsp;</strong>Wilton Plaza, Wilton Place, Dublin 2,&nbsp;Irland. LinkedIn
                            verfügt über eine Zertifizierung nach dem EU-US-Privacy-Shield. LinkedIn verwendet
                            Werbecookies.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p><strong>Wenn Sie LinkedIn-Werbe-Cookies deaktivieren möchten, nutzen Sie bitte folgenden
                                Link:&nbsp;</strong><a
                                href="https://www.linkedin.com/psettings/guest-controls/retargeting-opt-out"
                                target="_blank"
                                rel="noreferrer noopener">https://www.linkedin.com/psettings/guest-controls/retargeting-opt-out</a>.
                        </p>
                        <!-- /wp:paragraph -->

                        <!-- wp:paragraph -->
                        <p>Details zu deren Umgang mit Ihren personenbezogenen Daten entnehmen Sie der
                            Datenschutzerklärung von LinkedIn:&nbsp;<a
                                href="https://www.linkedin.com/legal/privacy-policy" target="_blank"
                                rel="noreferrer noopener">https://www.linkedin.com/legal/privacy-policy</a>.</p>
                        <!-- /wp:paragraph -->

                        <!-- wp:heading {"level":5} -->
                        <h5>Tumblr</h5>
                        <!-- /wp:heading -->

                        <!-- wp:paragraph -->
                        <p>Wir verfügen über ein Profil bei Tumblr. Anbieter ist die Tumblr, Inc., 35 East 21st St, 10th
                            Floor, New York, NY 10010, USA. Details zu deren Umgang mit Ihren personenbezogenen Daten
                            entnehmen Sie der Datenschutzerklärung von Tumblr:&nbsp;<a
                                href="https://www.tumblr.com/privacy/de" target="_blank"
                                rel="noreferrer noopener">https://www.tumblr.com/privacy/de</a>.</p>
                        <!-- /wp:paragraph -->
                    </div>
                </div>
            </div>
            <!-- end of .container-->

        </section>
        <!-- <section> close ============================-->
        <!-- ============================================-->







        @include('layouts.footer')
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    {{--
    <div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1"
        aria-labelledby="settings-offcanvas">
        <div class="offcanvas-header settings-panel-header bg-shape">
            <div class="z-index-1 py-1 light">
                <h5 class="text-white"> <span class="fas fa-palette me-2 fs-0"></span>Settings</h5>
                <p class="mb-0 fs--1 text-white opacity-75"> Set your own customized style</p>
            </div>
            <button class="btn-close btn-close-white z-index-1 mt-0" type="button" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body scrollbar-overlay px-card" id="themeController">
            <h5 class="fs-0">Color Scheme</h5>
            <p class="fs--1">Choose the perfect color mode for your app.</p>
            <div class="btn-group d-block w-100 btn-group-navbar-style">
                <div class="row gx-2">
                    <div class="col-6">
                        <input class="btn-check" id="themeSwitcherLight" name="theme-color" type="radio"
                            value="light" data-theme-control="theme" />
                        <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherLight"> <span
                                class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                    src="{{ asset('public/dashboard') }}/assets/img/generic/falcon-mode-default.jpg"
                                    alt="" /></span><span class="label-text">Light</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="themeSwitcherDark" name="theme-color" type="radio"
                            value="dark" data-theme-control="theme" />
                        <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherDark"> <span
                                class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                    src="{{ asset('public/dashboard') }}/assets/img/generic/falcon-mode-dark.jpg"
                                    alt="" /></span><span class="label-text"> Dark</span></label>
                    </div>
                </div>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-start"><img class="me-2"
                        src="{{ asset('public/dashboard') }}/assets/img/icons/left-arrow-from-left.svg"
                        width="20" alt="" />
                    <div class="flex-1">
                        <h5 class="fs-0">RTL Mode</h5>
                        <p class="fs--1 mb-0">Switch your language direction </p><a class="fs--1"
                            href="{{ asset('public/dashboard') }}/documentation/customization/configuration.html">RTL
                            Documentation</a>
                    </div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input ms-0" id="mode-rtl" type="checkbox"
                        data-theme-control="isRTL" />
                </div>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-start"><img class="me-2"
                        src="{{ asset('public/dashboard') }}/assets/img/icons/arrows-h.svg" width="20"
                        alt="" />
                    <div class="flex-1">
                        <h5 class="fs-0">Fluid Layout</h5>
                        <p class="fs--1 mb-0">Toggle container layout system </p><a class="fs--1"
                            href="{{ asset('public/dashboard') }}/documentation/customization/configuration.html">Fluid
                            Documentation</a>
                    </div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input ms-0" id="mode-fluid" type="checkbox"
                        data-theme-control="isFluid" />
                </div>
            </div>
            <hr />
            <div class="d-flex align-items-start"><img class="me-2"
                    src="{{ asset('public/dashboard') }}/assets/img/icons/paragraph.svg" width="20"
                    alt="" />
                <div class="flex-1">
                    <h5 class="fs-0 d-flex align-items-center">Navigation Position </h5>
                    <p class="fs--1 mb-2">Select a suitable navigation system for your web application </p>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="option-navbar-vertical" type="radio"
                                name="navbar" value="vertical"
                                data-page-url="{{ asset('public/dashboard') }}/modules/components/navs-and-tabs/vertical-navbar.html"
                                data-theme-control="navbarPosition" />
                            <label class="form-check-label" for="option-navbar-vertical">Vertical</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="option-navbar-top" type="radio" name="navbar"
                                value="top"
                                data-page-url="{{ asset('public/dashboard') }}/modules/components/navs-and-tabs/top-navbar.html"
                                data-theme-control="navbarPosition" />
                            <label class="form-check-label" for="option-navbar-top">Top</label>
                        </div>
                        <div class="form-check form-check-inline me-0">
                            <input class="form-check-input" id="option-navbar-combo" type="radio"
                                name="navbar" value="combo"
                                data-page-url="{{ asset('public/dashboard') }}/modules/components/navs-and-tabs/combo-navbar.html"
                                data-theme-control="navbarPosition" />
                            <label class="form-check-label" for="option-navbar-combo">Combo</label>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <h5 class="fs-0 d-flex align-items-center">Vertical Navbar Style</h5>
            <p class="fs--1 mb-0">Switch between styles for your vertical navbar </p>
            <p> <a class="fs--1"
                    href="{{ asset('public/dashboard') }}/modules/components/navs-and-tabs/vertical-navbar.html#navbar-styles">See
                    Documentation</a></p>
            <div class="btn-group d-block w-100 btn-group-navbar-style">
                <div class="row gx-2">
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-transparent" type="radio" name="navbarStyle"
                            value="transparent" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-transparent"> <img
                                class="img-fluid img-prototype"
                                src="{{ asset('public/dashboard') }}/assets/img/generic/default.png"
                                alt="" /><span class="label-text"> Transparent</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-inverted" type="radio" name="navbarStyle"
                            value="inverted" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-inverted"> <img
                                class="img-fluid img-prototype"
                                src="{{ asset('public/dashboard') }}/assets/img/generic/inverted.png"
                                alt="" /><span class="label-text"> Inverted</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-card" type="radio" name="navbarStyle"
                            value="card" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-card"> <img
                                class="img-fluid img-prototype"
                                src="{{ asset('public/dashboard') }}/assets/img/generic/card.png"
                                alt="" /><span class="label-text"> Card</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-vibrant" type="radio" name="navbarStyle"
                            value="vibrant" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-vibrant"> <img
                                class="img-fluid img-prototype"
                                src="{{ asset('public/dashboard') }}/assets/img/generic/vibrant.png"
                                alt="" /><span class="label-text"> Vibrant</span></label>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5"><img class="mb-4"
                    src="{{ asset('public/dashboard') }}/assets/img/icons/spot-illustrations/47.png"
                    alt="" width="120" />
                <h5>Like What You See?</h5>
                <p class="fs--1">Get Falcon now and create beautiful dashboards with hundreds of widgets.</p><a
                    class="mb-3 btn btn-primary"
                    href="https://themes.getbootstrap.com/product/falcon-admin-dashboard-webapp-template/"
                    target="_blank">Purchase</a>
            </div>
        </div>
    </div><a class="card setting-toggle" href="#settings-offcanvas" data-bs-toggle="offcanvas">
        <div class="card-body d-flex align-items-center py-md-2 px-2 py-1">
            <div class="bg-soft-primary position-relative rounded-start" style="height:34px;width:28px">
                <div class="settings-popover"><span class="ripple"><span
                            class="fa-spin position-absolute all-0 d-flex flex-center"><span
                                class="icon-spin position-absolute all-0 d-flex flex-center">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19.7369 12.3941L19.1989 12.1065C18.4459 11.7041 18.0843 10.8487 18.0843 9.99495C18.0843 9.14118 18.4459 8.28582 19.1989 7.88336L19.7369 7.59581C19.9474 7.47484 20.0316 7.23291 19.9474 7.03131C19.4842 5.57973 18.6843 4.28943 17.6738 3.20075C17.5053 3.03946 17.2527 2.99914 17.0422 3.12011L16.393 3.46714C15.6883 3.84379 14.8377 3.74529 14.1476 3.3427C14.0988 3.31422 14.0496 3.28621 14.0002 3.25868C13.2568 2.84453 12.7055 2.10629 12.7055 1.25525V0.70081C12.7055 0.499202 12.5371 0.297594 12.2845 0.257272C10.7266 -0.105622 9.16879 -0.0653007 7.69516 0.257272C7.44254 0.297594 7.31623 0.499202 7.31623 0.70081V1.23474C7.31623 2.09575 6.74999 2.8362 5.99824 3.25599C5.95774 3.27861 5.91747 3.30159 5.87744 3.32493C5.15643 3.74527 4.26453 3.85902 3.53534 3.45302L2.93743 3.12011C2.72691 2.99914 2.47429 3.03946 2.30587 3.20075C1.29538 4.28943 0.495411 5.57973 0.0322686 7.03131C-0.051939 7.23291 0.0322686 7.47484 0.242788 7.59581L0.784376 7.8853C1.54166 8.29007 1.92694 9.13627 1.92694 9.99495C1.92694 10.8536 1.54166 11.6998 0.784375 12.1046L0.242788 12.3941C0.0322686 12.515 -0.051939 12.757 0.0322686 12.9586C0.495411 14.4102 1.29538 15.7005 2.30587 16.7891C2.47429 16.9504 2.72691 16.9907 2.93743 16.8698L3.58669 16.5227C4.29133 16.1461 5.14131 16.2457 5.8331 16.6455C5.88713 16.6767 5.94159 16.7074 5.99648 16.7375C6.75162 17.1511 7.31623 17.8941 7.31623 18.7552V19.2891C7.31623 19.4425 7.41373 19.5959 7.55309 19.696C7.64066 19.7589 7.74815 19.7843 7.85406 19.8046C9.35884 20.0925 10.8609 20.0456 12.2845 19.7729C12.5371 19.6923 12.7055 19.4907 12.7055 19.2891V18.7346C12.7055 17.8836 13.2568 17.1454 14.0002 16.7312C14.0496 16.7037 14.0988 16.6757 14.1476 16.6472C14.8377 16.2446 15.6883 16.1461 16.393 16.5227L17.0422 16.8698C17.2527 16.9907 17.5053 16.9504 17.6738 16.7891C18.7264 15.7005 19.4842 14.4102 19.9895 12.9586C20.0316 12.757 19.9474 12.515 19.7369 12.3941ZM10.0109 13.2005C8.1162 13.2005 6.64257 11.7893 6.64257 9.97478C6.64257 8.20063 8.1162 6.74905 10.0109 6.74905C11.8634 6.74905 13.3792 8.20063 13.3792 9.97478C13.3792 11.7893 11.8634 13.2005 10.0109 13.2005Z"
                                        fill="#2A7BE4"></path>
                                </svg></span></span></span></div>
            </div><small
                class="text-uppercase text-primary fw-bold bg-soft-primary py-2 pe-2 ps-1 rounded-end">customize</small>
        </div>
    </a> --}}


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('public/dashboard') }}/vendors/popper/popper.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/anchorjs/anchor.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/is/is.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/typed.js/typed.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/fontawesome/all.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/list.js/list.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/assets/js/theme.js"></script>

</body>

</html>
