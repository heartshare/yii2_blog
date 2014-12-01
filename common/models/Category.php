<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property string $category_name
 * @property string $slug
 * @property string $sort
 * @property integer $parent_id
 * @property string $description
 *
 * @property Article[] $articles
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'parent_id'], 'integer'],
            [['category_name'], 'required', 'message' => '{attribute}不能为空'],
            [['category_name'], 'string', 'max' => 45],
            [['slug', 'description'], 'string', 'max' => 255],
            [['category_name'], 'unique', 'message' => '{attribute}:"{value}"已经存在~\(≧▽≦)/~啦啦啦'],
            [['slug'], 'unique'],
            ['sort', 'default', 'value' => 0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_name' => Yii::t('app', 'Category Name'),
            'slug' => Yii::t('app', 'Slug'),
            'sort' => Yii::t('app', 'Sort'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->slug = empty($this->slug) ? $this->category_name : $this->slug;
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }
}
