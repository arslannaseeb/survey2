<?php

use Illuminate\Database\Seeder;
use App\Survey;

class SurveyAndAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $surveyModel = new Survey();
        $surveyModel->name = "Test Survey";
        $surveyModel->description = "Test survey description";
        $surveyModel->save();

        $surveyAttributes = [
            [
                'survey_id' => $surveyModel->id,
                'label' => 'Name',
                'label_value' => '',
                'label_type' => 'text_field'
            ],
            [
                'survey_id' => $surveyModel->id,
                'label' => 'Province',
                'label_value' => 'Punjab,Sindh,Balochistan,KPK',
                'label_type' => 'dropdown'
            ],
            [
                'survey_id' => $surveyModel->id,
                'label' => 'Gender',
                'label_value' => 'Male,Female',
                'label_type' => 'radio_button'
            ],
            [
                'survey_id' => $surveyModel->id,
                'label' => 'Interests',
                'label_value' => 'Music,Art,Religion,Movies,Politics,Science,Maths',
                'label_type' => 'checkbox'
            ],
            [
                'survey_id' => $surveyModel->id,
                'label' => 'Biography',
                'label_value' => '',
                'label_type' => 'text_area'
            ],
        ];

        //Insert data in survey attributes table
        DB::table('survey_attributes')->insert($surveyAttributes);
    }
}
