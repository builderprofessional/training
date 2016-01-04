<?php
/**
 * This class represents one training course.
 *
 * @copyright 2016 Third Engine Software
 */
namespace Training\TrainingBundle\Model;


use Training\TrainingBundle\Model\om\BaseCoursePeer;



class CoursePeer extends BaseCoursePeer
{
  /**
   * This is a definition of extra available data that can be retried from PropelSOA along with a course.
   *
   * @var array
   */
  public $linkedData = [
    'Authorized' => 'isAuthorized',
  ];
}
