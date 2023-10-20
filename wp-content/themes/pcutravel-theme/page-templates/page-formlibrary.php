<?php
/**
* Template Name: Form Library Page
*/

get_header();

while(have_posts()) {
    the_post();
    pageBanner();
?>

<section id="content" class="forms-library">
            <div class="content-block container">
                <div>
                    <table>
                        <tbody>
                            <tr style="height: 18px">
                                <td style="width: 5.91853%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>&nbsp;</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>&nbsp;Type of Claim</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; text-align: left; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53); color: rgba(6, 162, 213, 1); font-weight: bold">&nbsp;Form(s) Required</td>
                            </tr>
                            <tr style="height: 18px">
                                <td style="width: 5.91853%; height: 18px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>1</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Medical – Illness</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_csa-form.pdf" title="CSA" target="_blank">CSA</a>
                                    <br>
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_student-scholar-verification-form.pdf" title="PCU_FORM_Student-Scholar-Verification-Form" target="_blank"></a>
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_student-scholar-verification-form.pdf" title="Student/Scholar-Verification" target="_blank">Student/Scholar Verification</a>
                                    (if applicable)
                                </td>
                            </tr>
                            <tr style="height: 18px">
                                <td style="width: 5.91853%; height: 18px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>2</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Medical-Accident</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_csa-form.pdf" title="CSA" target="_blank">CSA</a>
                                    <br>
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_general-accident-questionnaire.pdf" title="Accident-Questionnaire" target="_blank">Accident Questionnaire</a>
                                    <br>
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_student-scholar-verification-form.pdf" title="Student-Scholar-Verification" target="_blank">Student/Scholar Verification</a>
                                    (if applicable)<br>
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_student-scholar-sports-accident-questionnaire.pdf" title="Student-Scholar-Sports-Accident-Questionnaire" target="_blank">Student/Scholar Sports Accident Questionnaire</a>
                                    (if &nbsp;&nbsp;applicable)<br>
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_adventure-sports-accident-questionnaire.pdf" title="Adventure Sports Accident Questionnaire" target="_blank">Adventure Sports Accident Questionnaire</a>
                                    (if applicable)
                                </td>
                            </tr>
                            <tr style="height: 18px">
                                <td style="width: 5.91853%; height: 18px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>3</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Emergency Medical Evacuation</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_csa-form.pdf" title="#1." target="_blank">#1.</a>
                                    and/or #2. above<br>
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_emergency-medical-evacuation-reunion-bedside-visit-form.pdf" title="Emergency Medical Evacuation Reunion Bedside Visit" target="_blank">Emergency Medical Evacuation Reunion Bedside Visit</a>
                                </td>
                            </tr>
                            <tr style="height: 18px">
                                <td style="width: 5.91853%; height: 18px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>4</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Reunion</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_csa-form.pdf" title="#1." target="_blank">#1.</a>
                                    &nbsp;and/or #2. above<br>
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_emergency-medical-evacuation-reunion-bedside-visit-form.pdf" title="Emergency Medical Evacuation Reunion Bedside Visit" target="_blank">Emergency Medical Evacuation Reunion Bedside Visit</a>
                                    <br>
                                </td>
                            </tr>
                            <tr style="height: 18px">
                                <td style="width: 5.91853%; height: 18px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>5</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Bedside Visit</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_csa-form.pdf" title="#1." target="_blank">#1.</a>
                                    &nbsp;and/or #2. above<br>
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_emergency-medical-evacuation-reunion-bedside-visit-form.pdf" title="Emergency Medical Evacuation Reunion Bedside Visit" target="_blank">Emergency Medical Evacuation Reunion Bedside Visit</a>
                                    <br>
                                </td>
                            </tr>
                            <tr style="height: 18px">
                                <td style="width: 5.91853%; height: 18px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>6</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Repatriation of Mortal Remains</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_csa-form.pdf" title="#1." target="_blank">#1.</a>
                                    and/or #2. above<br>
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_ad-and-repat-of-remains-questionnaire.pdf" title="Accidental Death/Repatriation of Remains Questionnaire" target="_blank">Accidental Death/Repatriation of Remains Questionnaire</a>
                                </td>
                            </tr>
                            <tr style="height: 18px">
                                <td style="width: 5.91853%; height: 18px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>7</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Local Burial or Cremation</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_csa-form.pdf" title="#1." target="_blank">#1.</a>
                                    . and/or #2. above<br>
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_ad-and-repat-of-remains-questionnaire.pdf" title="Accidental Death/Repatriation of Remains Questionnaire" target="_blank">Accidental Death/Repatriation of Remains Questionnaire</a>
                                </td>
                            </tr>
                            <tr style="height: 18px">
                                <td style="width: 5.91853%; height: 18px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>8</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Return of Minor Child(ren)</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_return-minor-child-questionnaire.pdf" title="Return Minor Child Questionnaire" target="_blank">Return Minor Child Questionnaire</a>
                                </td>
                            </tr>
                            <tr style="height: 18px">
                                <td style="width: 5.91853%; height: 18px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>9</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Trip Interruption</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 18px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_trip-interruption-claim-form.pdf" title="Trip Interruption Claim" target="_blank">Trip Interruption Claim</a>
                                </td>
                            </tr>
                            <tr style="height: 26px">
                                <td style="width: 5.91853%; height: 26px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>10</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 26px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Natural Disaster Replacement</span>
                                    </strong>
                                    <br>
                                    <strong>
                                        <span>Accommodations</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 26px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_political-evac-and-repat-claim-form.pdf" title="Political Evac and Repat Claim" target="_blank"></a>
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_natural-disaster-accomo-and-evac-and-repat.pdf" title="Natural Disaster Daily Replacement Accommodation/ Natural Disaster Evacuation and Repatriation" target="_blank">Natural Disaster Daily Replacement Accommodation/ Natural Disaster Evacuation and Repatriation</a>
                                </td>
                            </tr>
                            <tr style="height: 26px">
                                <td style="width: 5.91853%; height: 26px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>11</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 26px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Natural Disaster Evacuation</span>
                                    </strong>
                                    <br>
                                    <strong>
                                        <span>and Repatriation</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 26px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_natural-disaster-accomo-and-evac-and-repat.pdf" title="Natural Disaster Daily Replacement Accommodation/ Natural Disaster Evacuation and Repatriation" target="_blank">Natural Disaster Daily Replacement Accommodation/ Natural Disaster Evacuation and Repatriation</a>
                                </td>
                            </tr>
                            <tr style="height: 26px">
                                <td style="width: 5.91853%; height: 26px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>12</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 26px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Political Evacuation and Repatriation</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 26px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_political-evac-and-repat-claim-form.pdf" title="Political Evacuation and Repatriation Claim" target="_blank">Political Evacuation and Repatriation Claim</a>
                                </td>
                            </tr>
                            <tr style="height: 26px">
                                <td style="width: 5.91853%; height: 26px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>13</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 26px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Accidental Death</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 26px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    #2 above<br>
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_ad-and-repat-of-remains-questionnaire.pdf" title="Accidental Death/Repatriation of Remains Questionnaire" target="_blank">Accidental Death/Repatriation of Remains Questionnaire</a>
                                </td>
                            </tr>
                            <tr style="height: 26px">
                                <td style="width: 5.91853%; height: 26px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>14</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 26px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Lost Checked Luggage</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 26px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_lost-checked-items-form.pdf" title="Lost Checked Items" target="_blank">Lost Checked Items</a>
                                    <br>
                                </td>
                            </tr>
                            <tr style="height: 26px">
                                <td style="width: 5.91853%; height: 26px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>15</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 26px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Personal Liability</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 26px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_personal-liability-claim-form.pdf" title="Personal Liability Claim" target="_blank">Personal Liability Claim</a>
                                    <br>
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_student-scholar-verification-form.pdf" title="Student-Scholar-Verification" target="_blank">Student/Scholar Verification</a>
                                    (if applicable)
                                </td>
                            </tr>
                            <tr style="height: 26px">
                                <td style="width: 5.91853%; height: 26px; text-align: center; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>16</span>
                                    </strong>
                                </td>
                                <td style="width: 30.2083%; height: 26px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(246, 198, 166, 0.55)">
                                    <strong>
                                        <span>Lost Checked Personal Equipment</span>
                                    </strong>
                                </td>
                                <td style="width: 63.8731%; height: 26px; padding-left: 40px; padding-bottom: 10px; padding-top: 10px; background-color: rgba(150, 199, 215, 0.53)">
                                    <a href="https://pcustoragewordpress.blob.core.windows.net/claim-forms/pcu_form_lost-checked-items-form.pdf" title="Lost Checked Items" target="_blank">Lost Checked Items</a>
                                    <br>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p>&nbsp;</p>
                </div>
            </div>
        </section>

        <?php }
    get_footer();
?>