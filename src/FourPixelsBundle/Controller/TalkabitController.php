<?php

namespace FourPixelsBundle\Controller;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use JMS\Serializer\SerializerBuilder;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

class TalkabitController extends FOSRestController {

  /**
   * Do something.
   * @PreAuthorize("hasRole('ROLE_USER')")
   * @ApiDoc(
   *   resource = true,
   *   statusCodes = {
   *     200 = "Returned when successful"
   *   }
   * )
   *
   * @Annotations\View()
   *
   * @param Request               $request      the request object
   * @param ParamFetcherInterface $paramFetcher param fetcher service
   *
   * @return array
   */
  public function getTalkabitAction(Request $request, ParamFetcherInterface $paramFetcher) {
    return ['message' => 'hello'];
  }

  /**
   * Presents the form to use to create a new note.
   *
   * @ApiDoc(
   *   resource = false,
   *   statusCodes = {
   *     200 = "Returned when successful"
   *   }
   * )
   *
   * @Annotations\Get("/talkabit/videoaudio/merge")
   * @Annotations\View()
   *
   * @return FormTypeInterface
   */
  public function newTalkabitVideoaudioMergeAction() {
    return $this->createForm(new \FourPixelsBundle\Form\TalkabitFileMergeType());
  }

  /**
   * Do something. 
   *
   * @ApiDoc(
   *   resource = false,
   *   input = "\FourPixelsBundle\Form\TalkabitFileMergeType",
   *   statusCodes = {
   *     200 = "Returned when successful",
   *     400 = "Returned when the form has errors"
   *   }
   * )
   * @Annotations\Post("/talkabit/videoaudio/merge")
   * @Annotations\View()
   * 
   * @param Request               $request      the request object
   *
   * @return FormTypeInterface[]|View
   */
  public function postTalkabitVideoAudioMergeAction(Request $request) {
    $logger = $this->get('logger');
    $mergeFiles = new \FourPixelsBundle\Utils\TalkabitFileMerge();
    $form = $this->createForm(new \FourPixelsBundle\Form\TalkabitFileMergeType(), $mergeFiles);
    if ($form->handleRequest($request)->isValid()) {
      /* @var $video \FourPixelsBundle\Entity\TalkabitFile */
      /* @var $audio \FourPixelsBundle\Entity\TalkabitFile */
      $em = $this->getDoctrine()->getManager();
      $video = $mergeFiles->getVideo();
      $audio = $mergeFiles->getAudio();
      $this->get('stof_doctrine_extensions.uploadable.manager')->markEntityToUpload($video, $video->getPath());
      $this->get('stof_doctrine_extensions.uploadable.manager')->markEntityToUpload($audio, $audio->getPath());
      $em->persist($video);
      $em->persist($audio);
      $em->flush();

      $audioFile = $audio->getPath();
      $videoFile = $video->getPath();
//      $mergedFile = $video->getPath() . '-merged.webm';
      $mergedFile = $video->getPath() . '-merged.mp4';
      $cmd = '-i ' . $audioFile . ' -i ' . $videoFile . ' -map 0:0 -map 1:0  ' . $mergedFile;
      exec('ffmpeg ' . $cmd . ' 2>&1', $out, $ret);
      if ($ret) {
        return ['error' => ":(", 'cmd' => $cmd, 'out' => $out];
      } else {
        unlink($audioFile);
        unlink($videoFile);
        return ['msg' => ":)", 'file' => 'data:video/mp4;base64,' . base64_encode(file_get_contents($mergedFile))];
      }
    }
    return ['msg' => "HELLO"];
  }

}
