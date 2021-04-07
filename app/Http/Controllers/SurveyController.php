<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use App\SurveyAttribute;

use Illuminate\Routing\Controller;


class SurveyController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Survey Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling survey related requests
      |
      */

    /***
     * Request object for dependency injection
     *
     * @var
     */
    private $request;
    /***
     * Survey Model for dependency injection
     * @var
     */
    private $surveyModel;

    /***
     * Constructor
     *
     * @param Request $request
     * @param Survey $surveyModel
     */
    public function __construct(Request $request, Survey $surveyModel)
    {
        $this->request = $request;
        $this->surveyModel = $surveyModel;
    }

    /**
     *List surveys
     *
     * @return View listing of surveys
     */
    public function index() {
        $survey = $this->surveyModel->getUserSurveys();
        //dd($survey);

        return view('index')->with(['surveys' => $survey]);
    }

    /***
     * Fill Form (Get Method)
     *
     * @param $id
     * @return View fill survey form
     */
    public function fillForm($id) {
        $survey = $this->surveyModel->getSurveyInfo($id);
        return view('fill')->with(['survey' => $survey]);
    }

    /***
     * View Form (Get Method)
     *
     * @param $id
     *
     * @return view view filled survey form
     */
    public function viewForm($id) {
        $surveyAttributeModel = new SurveyAttribute();
        $surveyNameAndSubmittedTime = $this->surveyModel->getSurveySubmittedTime($id);
        $submittedSurvey = $surveyAttributeModel->getFilledSurvey($id);
        return view('view')->with(['submittedSurvey' => $submittedSurvey,
                                           'surveyNameAndSubmittedTime' => $surveyNameAndSubmittedTime]);
    }

    /***
     * Save or submit survey
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveForm() {

        $surveyId = $this->request->get('survey_id');
        //dd($surveyId);
        $surveySaveMethod = $this->request->get('method','Save');
        $surveyAttributeModel = new SurveyAttribute();
        $formDataValues = $this->request->all();
        $surveyAttributeSubmissions = [];
        foreach ($formDataValues as $key => $value) {
            if(preg_match('/^[a-zA-z0-9]+\_\d+$/i', $key)) {
                $extractedFieldInfo = explode('_', $key);
                $extractedId = intval($extractedFieldInfo[(sizeof($extractedFieldInfo) - 1)]);
                $surveyAttributeSubmissions[$extractedId] = is_array($value) ? implode(',', $value) : trim($value);
            }
        }
        $surveyAttributeModel->addOrUpdateAttributeSubmission($surveyAttributeSubmissions);
        $this->surveyModel->updateUserSurveyStatus($surveyId, $surveySaveMethod);
        $successMessage = ($surveySaveMethod == 'submit') ? 'Survey Submitted Successfully' : 'Survey Saved Successfully';
        return redirect()->route('survey-list')->with('success', $successMessage);
    }
}
