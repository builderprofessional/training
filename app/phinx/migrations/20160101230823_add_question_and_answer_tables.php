<?php

use Phinx\Migration\AbstractMigration;

class AddQuestionAndAnswerTables extends AbstractMigration
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
      CREATE TABLE IF NOT EXISTS training_question (
        training_question_id INT(11) NOT NULL AUTO_INCREMENT,
        date_modified TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        date_created DATETIME NOT NULL,
        auth_user_id INT (11) NOT NULL,
        training_course_id INT (11),
        PRIMARY KEY (training_question_id),
        KEY date_created (date_created),
        KEY auth_user_id (auth_user_id),
        KEY training_course_id (training_course_id)
      ) ENGINE=InnoDB DEFAULT CHARSET=UTF8 AUTO_INCREMENT=1;
    ");

    $this->execute("
      ALTER TABLE training_question
        ADD CONSTRAINT training_question_ibfk_1 FOREIGN KEY (auth_user_id) REFERENCES auth_user (auth_user_id);
    ");

    $this->execute("
      ALTER TABLE training_question
        ADD CONSTRAINT training_question_ibfk_2 FOREIGN KEY (training_course_id) REFERENCES training_course (training_course_id);
    ");

    $this->execute("
      CREATE TABLE IF NOT EXISTS training_answer (
        training_answer_id INT(11) NOT NULL AUTO_INCREMENT,
        date_modified TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        date_created DATETIME NOT NULL,
        training_question_id INT (11) NOT NULL,
        auth_user_id INT (11) NOT NULL,
        PRIMARY KEY (training_answer_id),
        KEY date_created (date_created),
        KEY training_question_id (training_question_id),
        KEY auth_user_id (auth_user_id)
      ) ENGINE=InnoDB DEFAULT CHARSET=UTF8 AUTO_INCREMENT=1;
    ");

    $this->execute("
      ALTER TABLE training_answer
        ADD CONSTRAINT training_answer_ibfk_1 FOREIGN KEY (training_question_id) REFERENCES training_question (training_question_id);
    ");

    $this->execute("
      ALTER TABLE training_answer
        ADD CONSTRAINT training_answer_ibfk_2 FOREIGN KEY (auth_user_id) REFERENCES auth_user (auth_user_id);
    ");
  }
}
