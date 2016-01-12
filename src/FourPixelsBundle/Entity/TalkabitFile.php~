<?php

namespace FourPixelsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Talkabit File
 * 
 * @ORM\Table(name="talkabit_file")
 * @ORM\Entity
 * @Gedmo\Uploadable(path="/srv/www/4pixels-api/web/uploads", filenameGenerator="SHA1", allowOverwrite=true, appendNumber=true)
 */
class TalkabitFile {

  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  /**
   * @ORM\Column(name="path", type="string")
   * @Gedmo\UploadableFilePath
   */
  private $path;

  /**
   * @ORM\Column(name="name", type="string")
   * @Gedmo\UploadableFileName
   */
  private $name;

  /**
   * @ORM\Column(name="mime_type", type="string")
   * @Gedmo\UploadableFileMimeType
   */
  private $mimeType;

  /**
   * @ORM\Column(name="size", type="decimal")
   * @Gedmo\UploadableFileSize
   */
  private $size;

  public function myCallbackMethod(array $info) {
    // Do some stuff with the file..
  }

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set path
   *
   * @param string $path
   *
   * @return TalkabitFile
   */
  public function setPath($path) {
    $this->path = $path;

    return $this;
  }

  /**
   * Get path
   *
   * @return string
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * Set name
   *
   * @param string $name
   *
   * @return TalkabitFile
   */
  public function setName($name) {
    $this->name = $name;

    return $this;
  }

  /**
   * Get name
   *
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set mimeType
   *
   * @param string $mimeType
   *
   * @return TalkabitFile
   */
  public function setMimeType($mimeType) {
    $this->mimeType = $mimeType;

    return $this;
  }

  /**
   * Get mimeType
   *
   * @return string
   */
  public function getMimeType() {
    return $this->mimeType;
  }

  /**
   * Set size
   *
   * @param string $size
   *
   * @return TalkabitFile
   */
  public function setSize($size) {
    $this->size = $size;

    return $this;
  }

  /**
   * Get size
   *
   * @return string
   */
  public function getSize() {
    return $this->size;
  }

}
