<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Private me | privacy</title>
    <meta name="description" content="@yield('meta_description', 'Laravel Starter')">
    <meta name="author" content="@yield('meta_author', 'FasTrax Infotech')">
    @yield('meta')

    <!-- datatables.full.min.css Includes following libraries:
           Bootstrap 5 5.0.1, jQuery 3 3.6.0, JSZip 2.5.0, pdfmake 0.1.36, DataTables 1.11.3,
           AutoFill 2.3.7, Buttons 2.0.1, Column visibility 2.0.1, HTML5 export 2.0.1, Print view 2.0.1,
           ColReorder 1.5.5, DateTime 1.1.1, FixedColumns 4.0.1, FixedHeader 3.2.0, KeyTable 2.6.4,
           Responsive 2.2.9, RowGroup 1.1.4, RowReorder 1.2.8, Scroller 2.0.5, SearchBuilder 1.3.0,
           SearchPanes 1.4.0, Select 1.3.3 -->
    {{ style('css/datatables.full.min.css') }}


    {{ style('css/fontawesome-5.15.4.min.css') }}

</head>

<body>

    <div id="app">

        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <p class="h1"> <i class="fas fa-home"></i>PRIVATE ME APP, USER RULES FOR TERMS AND CONDITIONS</h1>
                        </div>
                        <div class="card-body">
                            <p>These rules, terms, and conditions are a formal “contract” agreement between the
                                PRIVATE ME application and the customers using the application.
                                The PRIVATE ME app is an application that saves photos, videos, files, and also
                                communications among users.
                                Once you register and use the application, you agree to this contract and its provisions.
                                Accordingly, you must not use the application if you do not agree to the terms and
                                conditions contained in this contract.
                                PRIVATE ME reserves the right to modify or change these Terms and Conditions without
                                prior notice and it is your responsibility as a user of the Application to periodically review
                                the rules and terms for updates.
                                We also urge you to review our Privacy Policy to learn more about how the PRIVATE ME
                                app uses the information provided to us by the app's users.</p>

                            <p><b>WARRANTIES AND GUARANTEES</b></p>

                            <ol>
                                <li>You have the full legal capacity to contract and as such you will not be in violation
                                    of any of the laws of your country and comply with all applicable laws.</li>
                                <li>You will provide correct and accurate information to the PRIVATE ME app and
                                    update it periodically.</li>
                                <li>Review and comply with any notices sent from the PRIVATE ME app in
                                    connection with your use of the services provided by the PRIVATE ME app.</li>
                                <li>Not to use the service or application to cause harm, harassment, or inconvenience
                                    to anyone, and the application will not be responsible for the misuse. You are solely
                                    responsible before the judiciary and any state authority. </li>
                                <li>Do not hinder the proper operation of the application and do not attempt to harm
                                    the service or the application in any way.
                                </li>
                                <li>- Maintain the password for your account or any means offered by the PRIVATE ME
                                    app that allows secure and confidential access to your account.</li>
                                <li>You will provide all evidence that proves your identity at the discretion of the
                                    PRIVATE ME app and the application has the right to refuse to provide the service
                                    or use the application without giving reasons. </li>
                            </ol>

                            <p><b>BREACH OF PLATFORM POLICY, TERMS AND RULES</b></p>

                            <p>PRIVATE ME reserves the right to seek to implement any remedies available for any
                                breach of its policy, terms, and rules to apply without limitation and has the right to
                                permanently withhold access to the Services without refunding any amounts due and this
                                is considered a threat of prosecution, defamation or libel. </p>

                            <p><b>INTELLECTUAL PROPERTY RIGHTS</b></p>

                            <p>All intellectual property rights in this platform and all materials related to or appearing on
                                it, including any content provided or included by the PRIVATE ME application. All
                                content uploaded by the PRIVATE ME application is the property of the owner of the
                                PRIVATE ME application and he has the right to dispose of this property as he wishes,
                                and you must not reproduce or allow anyone for any reason to use or reproduce the services
                                or any trademarks or other trade names that appear in the services.
                            </p>

                            <p><b>PAYMENT </b></p>

                            <p>PRIVATE ME application reserves the right to charge new fees for the use of the
                                Application and/or the Service. If the PRIVATE ME app decides to charge a new fee you
                                will be informed and allowed to continue or terminate the contract. You must pay for the
                                Services through approved electronic payment methods as soon as the Service is provided
                                to you. The PRIVATE ME shall not bear any legal or personal responsibility to pay any
                                funds outside of the application account. </p>

                            <p><b>LEGAL LIABILITY</b></p>

                            <ol>
                                <li>The information, recommendations, and services or any of them provided to you
                                    on or through the Website, Service and App are for general information purposes
                                    only and do not represent any advice.</li>
                                <li>PRIVATE ME will, as much as possible, maintain the correctness and updating of
                                    the Site and the Application and its contents but does not guarantee that the contents
                                    of the Site or the Application are free from errors, defects, malware, and viruses
                                    and does not guarantee the correctness, accuracy, and updating of the Website and
                                    the Application.</li>
                                <li>PRIVATE ME app shall not be liable for any damages resulting from the use or
                                    inability to use the Site or the Application including damages caused by the
                                    malware or viruses nor shall it be liable for incorrect or incomplete information,
                                    website, or the Application unless such damage is caused by intentional misconduct
                                    or gross negligence on the part of PRIVATE ME.</li>
                                <li>PRIVATE ME shall not be liable for any damages resulting from the use or inability
                                    to use electronic means of communication with the Website or with the Application
                                    including but not limited to (damages resulting from non-delivery, late delivery or
                                    interception of electronic correspondence or manipulation of electronic
                                    correspondence by third parties or Computer programs used for electronic
                                    correspondence and transmission of viruses.</li>
                                <li>The quality of the services is your responsibility and the PRIVATE ME app does
                                    not bear any responsibility in this aspect, however, PRIVATE ME has the right to
                                    review your performance and therefore cancel your license.
                                </li>
                                <li>The PRIVATE ME application does not accept responsibility for any or all of the
                                    above acts, actions, conduct, or negligence of the users.</li>
                            </ol>

                            <p><b>MODIFY SERVICES</b></p>
                            <p>PRIVATE ME reserves the right and sole discretion to do at any time:</p>
                            <ol>
                                <li>Change the Services or any related materials or discontinue the publication of its
                                    Services.</li>
                                <li>If ASC decides to stop the publication of services, it may voluntarily replace the
                                    services with other materials.
                                </li>
                            </ol>

                            <p><b>SECURITY</b></p>

                            <ol>
                                <li>Acknowledge that you are solely responsible for the privacy of the Services and are
                                    solely responsible for their use by anyone else using your account, username,
                                    password, or access credits.</li>
                                <li>Consent to notify private ME if you become aware of any loss, theft, or
                                    unauthorized use of any password, username, IP address, or other methods of
                                    accessing the Services . </li>
                            </ol>

                            <p><b>DEALING WITH THIRD PARTIES
                                </b></p>

                            <ol>
                                <li>During the use of the Website, the Application, and the Service, any third party may
                                    provide links to websites owned and controlled by third parties in order to
                                    correspond with third parties, purchase products or services from third parties, or
                                    participate in promotional offers that move you out of the Site, the Application, and
                                    the Service and are outside of the control of PRIVATE ME.</li>
                                <li>While using the Website, the Application, and the Service, you may correspond
                                    with, purchase goods or services, or participate in promotional offers from
                                    providers, advertisers, or sponsors offering their goods or services via a link on the
                                    Website or through the Application or the Service. These links take you outside the
                                    Website, the Application, and the Service and are outside the control of PRIVATE
                                    ME. The Websites which you may link has independent terms and conditions as
                                    well as an independent privacy policy. ASEC is not responsible for, and cannot be
                                    held accountable for, the content and activities of those websites, and you,
                                    therefore, bear the entire risk of visiting or accessing those websites.</li>
                                <li>Please note that these other sites may send user profiles, collect data, or request
                                    personal information and we recommend that you check the terms of use or privacy
                                    policies on those sites before using them</li>
                            </ol>

                            <p><b>CONTRACT TERM AND TERMINATION</b></p>
                            <p>The contract between you and the PRIVATE ME application is for an indefinite period.
                                You are entitled to terminate the contract at any time by permanently deleting the
                                application on your smartphone and thus disabling your use of the service. You can close
                                your user account at any time.
                                PRIVATE ME has the right to terminate the contract at any time (by disabling your use of
                                the Service) if you do any of the following:</p>

                            <p>PRIVATE ME has the right to terminate the contract at any time (by disabling your use of
                                the Service) if you do any of the following:</p>

                            <ol>
                                <li>
                                    Violation or breach of any of the User Terms.
                                </li>
                                <li>If ASEC sees that you are abusing the platform or service. ASEC is not obliged to
                                    give prior notice of termination of the Contract.
                                </li>
                            </ol>

                            <p><b>SEVERABILITY</b></p>

                            <p>The invalidity of any provision of these User Terms shall not affect the validity of the rest
                                of the other provisions contained therein. In the event of any invalid provision in these User
                                Terms or an unacceptable provision in certain circumstances in accordance with the
                                standards of reasonableness and fairness and to this extent only a provision shall act in its
                                place as agreed by the Parties which shall be acceptable for all circumstances and shall
                                conform to the provisions of the invalid as far as possible taking into account the content
                                and purpose of these User Terms.</p>


                            <p><b>MODIFY SERVICE AND USER TERMS </b></p>
                            <p>PRIVATE ME reserves the right at its sole discretion to modify, replace, change, suspend,
                                or discontinue any of these User Terms (including without limitation the provision of any
                                feature, database, or content) at any time by posting a notice on the Site or by sending a
                                notice to you through the Application or via email. PRIVATE ME may also place
                                restrictions on certain features and services or limit your access to parts of the entire Service
                                or the Service without notice or liability.</p>

                            <p><b> NOTIFICATIONS </b></p>
                            <p>
                                The PRIVATE ME application may issue a notification by sending a general notice of the
                                service or platform or by sending an email to your registered mailing address in the account
                                information of the PRIVATE ME application or by sending a letter by regular mail to your
                                registered address in the account information of the PRIVATE ME application.
                            </p>

                            <p><b> GOVERNING LAW AND DISPUTE RESOLUTION</b></p>
                            <p>These User Terms shall be subject and apply to the settlement of any dispute, claim or
                                controversy arising out of or related to these User Terms or any violation thereof,
                                termination, implementation, interpretation, validity, or use of the Site, Service or
                                Application to the laws and regulations in the Kingdom of Saudi Arabia and shall be
                                interpreted in accordance with them.</p>
                            <p><b>Contact US</b></p>
                            <p>private2030me@gmail.com</p>
                            <p>+966552443446</p>
                        </div>
                    </div>
                    <!--card-->
                </div>
                <!--col-->
            </div>
            <!--row-->
        </div><!-- container -->
    </div><!-- #app -->

    <!--Start JS Scripts ------------------------->
    <!-- datatables.full.min Includeds following libraries:
          Bootstrap 5 5.0.1, jQuery 3 3.6.0, JSZip 2.5.0, pdfmake 0.1.36, DataTables 1.11.3,
          AutoFill 2.3.7, Buttons 2.0.1, Column visibility 2.0.1, HTML5 export 2.0.1, Print view 2.0.1,
          ColReorder 1.5.5, DateTime 1.1.1, FixedColumns 4.0.1, FixedHeader 3.2.0, KeyTable 2.6.4,
          Responsive 2.2.9, RowGroup 1.1.4, RowReorder 1.2.8, Scroller 2.0.5, SearchBuilder 1.3.0,
          SearchPanes 1.4.0, Select 1.3.3 -->
    {{ script('js/datatables.full.min.js') }}

    <!-- JS Scripts in vendor folder be compiled in vendor.js -->
    {{-- script(mix('js/vendor.js')) --}}

    <!-- JS Scripts (Vue or React) in resources folder be compiled in frontend.js -->
    {{-- script(mix('js/frontend.js')) --}}

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    @include('includes.partials.ga')
    <!-- END JS Scripts ---------------------------->
</body>

</html>