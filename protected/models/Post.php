<?php

/**
 * This is the model class for table "{{post}}".
 *
 * The followings are the available columns in table '{{post}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $author_id
 * @property string $description
 * @property string $keywords
 * @property integer $sort_order
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property Users $author
 */
class Post extends CActiveRecord
{
	const STATUS_DRAFT=1;
    const STATUS_PUBLISHED=2;
    const STATUS_ARCHIVED=3;
    public $limit=2;
    public $icon;
    	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{post}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
	    return array(
	        array('title, content, status', 'required'),
	        array('title', 'length', 'max'=>128),
	        array('status', 'in', 'range'=>array(1,2,3)),
	        array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/',
	            'message'=>'У тегах можна використовувати лише літери.'),
	        array('tags', 'normalizeTags'),
	        array('icon', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
	        array('title, status', 'safe', 'on'=>'search'),
	    );
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
	    return array(
	        'author' => array(self::BELONGS_TO, 'User', 'author_id'),
	        'comments' => array(self::HAS_MANY, 'Comment', 'post_id',
	            'condition'=>'comments.status='.Comment::STATUS_APPROVED,
	            'order'=>'comments.create_time DESC'),
	        'commentCount' => array(self::STAT, 'Comment', 'post_id',
	            'condition'=>'status='.Comment::STATUS_APPROVED),
	    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'tags' => 'Tags',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'author_id' => 'Author',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'sort_order' => 'Sort Order',
            'icon' => 'Image',
        );
		
		}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->compare('id',$this->id);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('content',$this->content,true);
        $criteria->compare('tags',$this->tags,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('create_time',$this->create_time,true);
        $criteria->compare('update_time',$this->update_time,true);
        $criteria->compare('author_id',$this->author_id);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('keywords',$this->keywords,true);
        $criteria->compare('sort_order',$this->sort_order,true);
        $criteria->compare('author',$this->author,true);
        $criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
                'defaultOrder'=>'sort_order ASC',
                ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Post the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function findRecentPosts($limit=2)
    {
        return $this->with('author')->findAll(array(
            'condition'=>'t.status='.self::STATUS_PUBLISHED,
            'order'=>'t.create_time DESC',
            'limit'=>3,
        ));
    }

	public function getUrl()
    {
        return Yii::app()->createUrl('post/view', array(
            'id'=>$this->id,
            'title'=>$this->title,
        ));
    }

    public function getTagLinks()
	{
		$links=array();
		foreach(Tag::string2array($this->tags) as $tag)
			$links[]=CHtml::link(CHtml::encode($tag), array('post/index', 'tag'=>$tag));
		return $links;
	}

    public function normalizeTags($attribute,$params)
	{
	    $this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
	}

	public static function string2array($tags)
	{
	    return preg_split('/\s*,\s*/',trim($tags),-1,PREG_SPLIT_NO_EMPTY);
	}
	 
	public static function array2string($tags)
	{
	    return implode(', ',$tags);
	}

	protected function beforeSave()
	{
	    if(parent::beforeSave())
	    {
	        if($this->isNewRecord)
	        {
	        	$post = Post::model()->findAll(); 
				foreach($post as $item)
				{
					$postID = $item->id;	
					$postRecord=Post::model()->findByPk($postID);
					$postRecord->saveCounters(array('sort_order'=>1));
				}
	            $this->author_id=Yii::app()->user->id;
	            $this->create_time= new CDbExpression('NOW()');
	        }
	        else
	            $this->update_time=new CDbExpression('NOW()');
	        return true;
	    }
	    else
	        return false;
	}

	protected function afterSave()
	{
	    parent::afterSave();
	    Tag::model()->updateFrequency($this->_oldTags, $this->tags);
	}
	 
	private $_oldTags;
	 
	protected function afterFind()
	{
	    parent::afterFind();
	    $this->_oldTags=$this->tags;
	}

	public function addComment($comment)
	{
	    if(Yii::app()->params['commentNeedApproval'])
	        $comment->status=Comment::STATUS_PENDING;
	    else
	        $comment->status=Comment::STATUS_APPROVED;
	    $comment->post_id=$this->id;
	    return $comment->save();
	}

	protected function afterDelete()
	{
		parent::afterDelete();
		Comment::model()->deleteAll('post_id='.$this->id);
		Tag::model()->updateFrequency($this->tags, '');
	}

	

}