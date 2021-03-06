<?php

namespace Grr\GrrBundle\Controller\Front;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Grr\Core\View\ViewLocator;
use Grr\GrrBundle\Entity\Area;
use Grr\GrrBundle\Entity\Room;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VueController.
 *
 * @Route("/front")
 */
class VueController extends AbstractController implements FrontControllerInterface
{
    private ViewLocator $viewLocator;

    public function __construct(ViewLocator $viewLocator)
    {
        $this->viewLocator = $viewLocator;
    }

    /**
     * @Route("/area/{area}/date/{date}/view/{view}/room/{room}", name="grr_front_view", methods={"GET"})
     * @Entity("area", expr="repository.find(area)")
     * @ParamConverter("room", options={"mapping"="id"})
     *
     * @param Area|null $area
     *
     * @throws Exception
     * @param DateTime|DateTimeImmutable $date
     */
    public function view(Area $area, DateTimeInterface $date, string $view, ?Room $room = null): Response
    {
        $renderService = $this->viewLocator->findViewerByView($view);

        return $renderService->render($date, $area, $room);
    }
}
