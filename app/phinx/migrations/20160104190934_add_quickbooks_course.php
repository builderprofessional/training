<?php

use Phinx\Migration\AbstractMigration;

class AddQuickbooksCourse extends AbstractMigration
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
    $product = $this->fetchRow("SELECT * FROM billing_product WHERE code='QUICKBOOKS_FOR_HOMEBUILDERS'");
    $productId = $product['billing_product_id'];

    $this->execute("
      INSERT INTO training_course (date_created, billing_product_id, name, code)
        VALUES (NOW(), {$productId}, 'QuickBooks for Homebuilders', 'QUICKBOOKS_FOR_HOMEBUILDERS');
    ");
  }
}
