<?php

namespace common\models;

use trntv\filekit\behaviors\UploadBehavior;
use Yii;

/**
 * This is the model class for table "widget_carousel_item".
 *
 * @property integer $id
 * @property integer $carousel_id
 * @property string $path
 * @property string $url
 * @property string $caption
 * @property integer $status
 * @property integer $order
 *
 * @property WidgetCarousel $carousel
 */
class WidgetCarouselItem extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget_carousel_item}}';
    }

    public function scenarios(){
        $scenarios = parent::scenarios();
        $key = array_search('carousel_id', $scenarios[self::SCENARIO_DEFAULT]);
        $scenarios[self::SCENARIO_DEFAULT][$key] = '!carousel_id';
        return $scenarios;
    }

    public function behaviors()
    {
        return [
            'path' => [
                'class' => UploadBehavior::className(),
                'uploadAttribute' => 'file',
                'resultAttribute' => 'path',
                'fileCategory' => 'carousel',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['carousel_id'], 'required'],
            [['file'], 'file', 'extensions'=>['gif', 'jpeg', 'jpg', 'png']],
            [['carousel_id', 'status', 'order'], 'integer'],
            [['url', 'caption'], 'string', 'max' => 1024],
            [['path'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'carousel_id' => Yii::t('common', 'Carousel ID'),
            'path' => Yii::t('common', 'Path'),
            'url' => Yii::t('common', 'Url'),
            'caption' => Yii::t('common', 'Caption'),
            'status' => Yii::t('common', 'Status'),
            'order' => Yii::t('common', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarousel()
    {
        return $this->hasOne(WidgetCarousel::className(), ['id' => 'carousel_id']);
    }
}
