<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ogl".
 *
 * @property int $id
 * @property string $control_date
 * @property int $control_no
 * @property string|null $staff_responsible
 * @property string $reference_gil
 * @property string|null $stakeholder
 * @property string|null $position
 * @property string|null $organization
 * @property string|null $purpose
 * @property string $status
 * @property string|null $date_released
 * @property int $author_id
 * @property string $created_at
 * @property string|null $updated_at
 */
class Ogl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ogl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reference_gil', 'status'], 'required'],
            [['control_date', 'date_released', 'created_at', 'updated_at'], 'safe'],
            [['control_no', 'author_id'], 'integer'],
            [['staff_responsible', 'stakeholder', 'position', 'organization', 'purpose', 'status'], 'string'],
            [['reference_gil'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'control_date' => 'Control Date',
            'control_no' => 'Control No',
            'staff_responsible' => 'Staff Responsible',
            'reference_gil' => 'Reference Gil',
            'stakeholder' => 'Stakeholder',
            'position' => 'Position',
            'organization' => 'Organization',
            'purpose' => 'Purpose',
            'status' => 'Status',
            'date_released' => 'Date Released',
            'author_id' => 'Author ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
