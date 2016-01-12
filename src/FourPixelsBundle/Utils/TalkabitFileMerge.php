<?php

namespace FourPixelsBundle\Utils;

use Symfony\Component\Validator\Constraints as Assert;

class TalkabitFileMerge {

  /**
   * @Assert\Type(type="FourPixelsBundle\Entity\TalkabitFile")
   * @Assert\Valid()
   */
  protected $video;

  /**
   * @Assert\Type(type="FourPixelsBundle\Entity\TalkabitFile")
   * @Assert\Valid()
   */
  protected $audio;
  /**
   * 
   * @return FourPixelsBundle\Entity\TalkabitFile
   */
  public function getVideo() {
    return $this->video;
  }

  public function setVideo(\FourPixelsBundle\Entity\TalkabitFile $video = null) {
    $this->video = $video;
  }

  /**
   * 
   * @return FourPixelsBundle\Entity\TalkabitFile
   */
  public function getAudio() {
    return $this->audio;
  }

  public function setAudio(\FourPixelsBundle\Entity\TalkabitFile $audio = null) {
    $this->audio = $audio;
  }

}
