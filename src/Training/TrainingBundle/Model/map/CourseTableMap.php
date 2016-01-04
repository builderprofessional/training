<?php

namespace Training\TrainingBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'training_course' table.
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
class CourseTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Training.TrainingBundle.Model.map.CourseTableMap';

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
        $this->setName('training_course');
        $this->setPhpName('Course');
        $this->setClassname('Training\\TrainingBundle\\Model\\Course');
        $this->setPackage('src.Training.TrainingBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('training_course_id', 'CourseId', 'INTEGER', true, null, null);
        $this->addColumn('date_modified', 'DateModified', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('date_created', 'DateCreated', 'TIMESTAMP', true, null, null);
        $this->addForeignKey('billing_product_id', 'BillingProductId', 'INTEGER', 'billing_product', 'billing_product_id', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('code', 'Code', 'VARCHAR', true, 255, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Product', 'Engine\\BillingBundle\\Model\\Product', RelationMap::MANY_TO_ONE, array('billing_product_id' => 'billing_product_id', ), null, null);
        $this->addRelation('Question', 'Training\\TrainingBundle\\Model\\Question', RelationMap::ONE_TO_MANY, array('training_course_id' => 'training_course_id', ), null, null, 'Questions');
    } // buildRelations()

} // CourseTableMap
