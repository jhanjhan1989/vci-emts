<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "him".
 *
 * @property int $id
 * @property string $control_date
 * @property int $control_no
 * @property string|null $staff_source
 * @property string|null $staff_responsible
 * @property string $reference_gil
 * @property string|null $stakeholder
 * @property string|null $position
 * @property string|null $organization
 * @property string|null $purpose
 * @property string|null $information_requested
 * @property int|null $no_of_disc
 * @property int|null $no_of_print
 * @property string $status
 * @property string|null $date_issued
 * @property string|null $date_released
 * @property int $author_id
 * @property string $created_at
 * @property string|null $updated_at
 */
class Him extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'him';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[  'reference_gil', 'status' ], 'required'],
            [['control_date', 'date_issued', 'date_released', 'created_at', 'updated_at'], 'safe'],
            [['control_no', 'no_of_disc', 'no_of_print', 'author_id'], 'integer'],
            [['staff_source', 'staff_responsible', 'stakeholder', 'position', 'organization', 'purpose', 'information_requested', 'status'], 'string'],
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
            'staff_source' => 'Staff Source',
            'staff_responsible' => 'Staff Responsible',
            'reference_gil' => 'GIL No.',
            'stakeholder' => 'Stakeholder',
            'position' => 'Position',
            'organization' => 'Organization ',
            'purpose' => 'Purpose',
            'information_requested' => 'Info. Requested',
            'no_of_disc' => '#Disc',
            'no_of_print' => '#Print',
            'status' => 'Status',
            'date_issued' => 'Issued',
            'date_released' => 'Released',
            'author_id' => 'Author ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
