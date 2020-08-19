<?php

namespace Grr\GrrBundle\Controller\Admin;

use Grr\Core\EntryType\Events\EntryTypeEventCreated;
use Grr\Core\EntryType\Events\EntryTypeEventDeleted;
use Grr\Core\EntryType\Events\EntryTypeEventUpdated;
use Grr\GrrBundle\Entity\EntryType;
use Grr\GrrBundle\TypeEntry\Form\TypeEntryType;
use Grr\GrrBundle\TypeEntry\Manager\TypeEntryManager;
use Grr\GrrBundle\TypeEntry\Repository\TypeEntryRepository;
use Grr\GrrBundle\TypeEntry\TypeEntryFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @Route("/admin/entrytype")
 * @IsGranted("ROLE_GRR_ADMINISTRATOR")
 */
class EntryTypeController extends AbstractController
{
    /**
     * @var TypeEntryRepository
     */
    private $typeEntryRepository;
    /**
     * @var TypeEntryManager
     */
    private $typeEntryManager;
    /**
     * @var TypeEntryFactory
     */
    private $typeEntryFactory;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(
        TypeEntryFactory $typeEntryFactory,
        TypeEntryRepository $typeEntryRepository,
        TypeEntryManager $typeEntryManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->typeEntryRepository = $typeEntryRepository;
        $this->typeEntryManager = $typeEntryManager;
        $this->typeEntryFactory = $typeEntryFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @Route("/", name="grr_admin_type_entry_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render(
            '@grr_admin/type_entry/index.html.twig',
            [
                'type_entries' => $this->typeEntryRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/new", name="grr_admin_type_entry_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $entryType = $this->typeEntryFactory->createNew();

        $form = $this->createForm(TypeEntryType::class, $entryType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typeEntryManager->insert($entryType);

            $this->eventDispatcher->dispatch(new EntryTypeEventCreated($entryType));

            return $this->redirectToRoute('grr_admin_type_entry_index');
        }

        return $this->render(
            '@grr_admin/type_entry/new.html.twig',
            [
                'type_entry' => $entryType,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="grr_admin_type_entry_show", methods={"GET"})
     */
    public function show(EntryType $typeArea): Response
    {
        return $this->render(
            '@grr_admin/type_entry/show.html.twig',
            [
                'type_entry' => $typeArea,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="grr_admin_type_entry_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EntryType $entryType): Response
    {
        $form = $this->createForm(TypeEntryType::class, $entryType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->typeEntryManager->flush();

            $this->eventDispatcher->dispatch(new EntryTypeEventUpdated($entryType));

            return $this->redirectToRoute(
                'grr_admin_type_entry_index',
                [
                    'id' => $entryType->getId(),
                ]
            );
        }

        return $this->render(
            '@grr_admin/type_entry/edit.html.twig',
            [
                'type_entry' => $entryType,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="grr_admin_type_entry_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EntryType $entryType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entryType->getId(), $request->request->get('_token'))) {
            $this->typeEntryManager->remove($entryType);
            $this->typeEntryManager->flush();

            $this->eventDispatcher->dispatch(new EntryTypeEventDeleted($entryType));
        }

        return $this->redirectToRoute('grr_admin_type_entry_index');
    }
}
