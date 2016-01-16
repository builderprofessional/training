<?php

use Phinx\Migration\AbstractMigration;

class AddPlanAndQuickBooksForHomebuildersProduct extends AbstractMigration
{
  /**
   * Change Method.
   *
   * Write your reversible migrations using this method.
   *
   * More information on writing migrations is available here:
   * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
   *
   * The following commands can be used in this method and Phinx will
   * automatically reverse them when rolling back:
   *
   *    createTable
   *    renameTable
   *    addColumn
   *    renameColumn
   *    addIndex
   *    addForeignKey
   *
   * Remember to call "create()" or "update()" and NOT "save()" when working
   * with the Table class.
   */
  public function change()
  {
    $this->execute("
      INSERT INTO billing_product (class_key, date_created, code, name, amount, description, position)
        VALUES ('one_time', NOW(), 'QUICKBOOKS_FOR_HOMEBUILDERS', 'QuickBooks for Homebuilders', 2990000, '', 1),
          ('recurring', NOW(), 'NEVER_STOP_LEARNING', 'Never Stop Learning', 290000, '', 0);
    ");
  }
}
