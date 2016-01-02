<?php

namespace Training\TrainingBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'training_answer' table.
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
class AnswerTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Training.TrainingBundle.Model.map.AnswerTableMap';

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
        $this->setName('training_answer');
        $this->setPhpName('Answer');
        $this->setClassname('Training\\TrainingBundle\\Model\\Answer');
        $this->setPackage('src.Training.TrainingBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('training_answer_id', 'AnswerId', 'INTEGER', true, null, null);
        $this->addColumn('date_modified', 'DateModified', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('date_created', 'DateCreated', 'TIMESTAMP', true, null, null);
        $this->addForeignKey('training_question_id', 'QuestionId', 'INTEGER', 'training_question', 'training_question_id', true, null, null);
        $this->addForeignKey('auth_user_id', 'AuthUserId', 'INTEGER', 'auth_user', 'auth_user_id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Question', 'Training\\TrainingBundle\\Model\\Question', RelationMap::MANY_TO_ONE, array('training_question_id' => 'training_question_id', ), null, null);
        $this->addRelation('User', 'Engine\\AuthBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('auth_user_id' => 'auth_user_id', ), null, null);
    } // buildRelations()

} // AnswerTableMap
