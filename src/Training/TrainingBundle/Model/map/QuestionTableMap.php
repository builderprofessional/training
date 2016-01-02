<?php

namespace Training\TrainingBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'training_question' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Training.TrainingBundle.Model.map
 */
class QuestionTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Training.TrainingBundle.Model.map.QuestionTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('training_question');
        $this->setPhpName('Question');
        $this->setClassname('Training\\TrainingBundle\\Model\\Question');
        $this->setPackage('src.Training.TrainingBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('training_question_id', 'QuestionId', 'INTEGER', true, null, null);
        $this->addColumn('date_modified', 'DateModified', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('date_created', 'DateCreated', 'TIMESTAMP', true, null, null);
        $this->addForeignKey('auth_user_id', 'AuthUserId', 'INTEGER', 'auth_user', 'auth_user_id', true, null, null);
        $this->addForeignKey('training_course_id', 'CourseId', 'INTEGER', 'training_course', 'training_course_id', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', 'Engine\\AuthBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('auth_user_id' => 'auth_user_id', ), null, null);
        $this->addRelation('Course', 'Training\\TrainingBundle\\Model\\Course', RelationMap::MANY_TO_ONE, array('training_course_id' => 'training_course_id', ), null, null);
        $this->addRelation('Answer', 'Training\\TrainingBundle\\Model\\Answer', RelationMap::ONE_TO_MANY, array('training_question_id' => 'training_question_id', ), null, null, 'Answers');
    } // buildRelations()

} // QuestionTableMap