<?php

namespace App;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
       /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /***
     * One to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function surveyAttributes() {
        return $this->hasMany('App\SurveyAttribute', 'survey_id', 'id');
    }
    /***
     * Get User Surveys
     *
     * @return surveys
     */
    public function getUserSurveys() {
        $userId = Auth::user()->id;
        
        $surveys = DB::table('survey_users')
                    ->join('surveys','survey_users.survey_id','=','surveys.id')
                    ->where('survey_users.user_id', '=', $userId)
                    ->get();



        // ->join('survey_users', 'survey_users.survey_id', '=', 'surveys.id')
        //                 ->where('survey_users.user_id', '=', $userId)
        //                 ->get();
         //dd($surveys);             
        return $surveys;
    }

    /***
     * Get Survey info
     *
     * @param $surveyId
     * @return survey
     */
    public function getSurveyInfo($surveyId) {
        $survey = $this->with(['surveyAttributes' => function($query) {
                            $query->with('surveySubmissions');
                       }])
                       ->join('survey_users as su', 'su.survey_id', '=', 'surveys.id')
                       ->where('su.user_id', '=', Auth::user()->id)
                       ->where('su.survey_id', '=', $surveyId)
                       ->first();
        return $survey;
    }

    /***
     * Update Survey Records for specific user
     *
     * @param $surveyId
     * @param $surveySaveMethod
     */
    public function updateUserSurveyStatus($surveyId, $surveySaveMethod) {
        DB::table('survey_users')
                ->where('user_id', '=', Auth::user()->id)
                ->where('survey_id', '=', $surveyId)
                ->update(['status' => ($surveySaveMethod == 'submit') ? 'Completed' : 'Partially Completed',
                          'submitted_at' => \Carbon\Carbon::now()]);
    }

    /***
     * Get Survey Submitted time and name
     *
     * @param $surveyId
     * @return mixed
     */
    public function getSurveySubmittedTime($surveyId) {
        $surveyNameAndSubmissionTime = $this->join('survey_users as su','su.survey_id', '=', 'surveys.id')
                                            ->where('su.user_id','=',Auth::user()->id)
                                            ->where('surveys.id','=',$surveyId)
                                            ->first(['surveys.name as name','su.submitted_at']);
        return $surveyNameAndSubmissionTime;
    }

    /***
     * Assign Surveys To New User
     * @param $userId
     */
    public function assignSurveysToNewUser($userId){
        $surveyIds = $this->all(['id'])->pluck('id')->toArray();
        // dd($surveyIds);
        $assignSurveys = [];
        if(count($surveyIds) > 0) {
            foreach($surveyIds as $surveyId) {
                $assignSurveys[] = ['user_id' => $userId,
                                    'survey_id' => $surveyId,
                                    'status' => 'Pending'
                                ];
            }
            DB::table('survey_users')->insert($assignSurveys);
        }

    }
}
