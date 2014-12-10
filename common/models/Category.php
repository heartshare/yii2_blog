<?php

namespace common\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property string $name
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
            [['name'], 'required', 'message' => '{attribute}不能为空'],
            [['name'], 'string', 'max' => 45],
            [['slug', 'description'], 'string', 'max' => 255],
            [['name'], 'unique', 'message' => '{attribute}:"{value}"已经存在~\(≧▽≦)/~啦啦啦'],
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
            'name' => Yii::t('app', 'Category Name'),
            'slug' => Yii::t('app', 'Slug'),
            'sort' => Yii::t('app', 'Sort'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->slug = empty($this->slug) ? $this->name : $this->slug;
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

    /**
     * 根据分类slug获得分类
     * @param string $slug
     * @return int|null
     */
    public static function getCategoryBySlug($slug)
    {
        if ($category = static::findOne(['slug' => $slug])) {
            return $category;
        };
        return null;
    }

    public static function getCategoryList()
    {
        $model = static::find();
        $countQuery = clone $model;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        return [
            'list' => $model->all(),
            'pages' => $pages
        ];
    }
}
