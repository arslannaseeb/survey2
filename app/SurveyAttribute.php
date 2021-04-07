<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class SurveyAttribute extends Model
{
        /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /***
     * Relationship with survey submissisions
     *
     * @return mixed
     */
    public function surveySubmissions() {
        return $this->belongsToMany('App\User', 'survey_submissions', 'survey_attribute_id', 'user_id')
                    ->where('user_id', '=', Auth::user()->id)
                    ->withPivot('value');
    }

    /***
     *
     * @param $attributeId
     * @param $value
     */
    public function addOrUpdateAttributeSubmission($surveySubmissions)
    {
        $attributeIds = array_keys($surveySubmissions);
        //Update survey submission values
        $submissionsToUpdate = DB::table('survey_submissions')
            ->whereIn('survey_attribute_id', $attributeIds)
            ->where('user_id', '=', Auth::user()->id)
            ->pluck('survey_attribute_id');

        foreach ($submissionsToUpdate as $key => $value) {
            if (array_key_exists($value, $surveySubmissions)) {
                DB::table('survey_submissions')
                    ->where('user_id', '=', Auth::user()->id)
                    ->where('survey_attribute_id', '=', $value)
                    ->update(['value' => $surveySubmissions[$value]]);
                unset($surveySubmissions[$value]);
            }
        }
        //Add survey submissions value
        $bulkInsertSurveySubmissions = [];
        foreach ($surveySubmissions as $key => $value) {
            $bulkInsertSurveySubmissions[] = ['survey_attribute_id' =>  $key,
                                              'user_id' => Auth::user()->id,
                                              'value' => $value
                                             ];
        }
        //Bulk insert submissions
        DB::table('survey_submissions')->insert($bulkInsertSurveySubmissions);

    }

    /***
     * Get filled survey
     *
     * @param $surveyId
     *
     * @return survey submissions
     */
    public function getFilledSurvey($surveyId) {
        $surveySubmissions = $this->join('survey_submissions as ss', 'ss.survey_attribute_id', '=', 'survey_attributes.id')
                                       ->where('survey_attributes.survey_id','=',$surveyId)
                                       ->where('ss.user_id','=',Auth::user()->id)
                                       ->get(['survey_attributes.label as label', 'ss.value']);
        return $surveySubmissions;
    }
}
