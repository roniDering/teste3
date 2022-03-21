<?php

namespace App\Controller;

use App\Entity\Contato;
use App\Form\ContatoType;
use App\Repository\ContatoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ContatoController extends AbstractController
{
    /**
     * @Route("/contato",name="contato_index")
     */

    public function index(EntityManagerInterface $em, ContatoRepository $contatoRepository)
    {
        $data['contatos'] = $contatoRepository->findAll();
        $data['titulo'] = "Tabela de Contatos";

        return $this->render('contato/index.html.twig', $data);
    }




    /**
     * @Route("/contato/adicionar", name="contato_adicionar")
     */
    public function adicionar(Request $request, EntityManagerInterface $em): Response
    {
        $msg = "";
        $contato = new Contato();
        $form = $this->createForm(ContatoType::class, $contato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($contato);
            $em->flush();
            $msg = "Contato cadastrado com sucesso!";
        }
        $data['titulo'] = "Adicionar Contato";
        $data['form']   = $form;
        $data['msg']    = $msg;
        return $this->renderForm('contato/form.html.twig', $data);
    }

    /**
     * @Route("/contato/editar{id}", name="contato_editar")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, ContatoRepository $contatoRepository) : Response
    {
       $msg ="";
       $contato = $contatoRepository->find($id);
       $form = $this->createForm(ContatoType::class,$contato);
       $form->handleRequest($request);

       if($form->isSubmitted()&& $form->isValid()){
           $em->flush();
           $msg="Editado com sucesso!";
       }
       $data['titulo']  = "Editar Contato";
       $data['form']    = $form;
       $data['msg']     = $msg;
       return $this->renderForm('contato/form.html.twig',$data);
       
    }


    /**
     * @Route("/contato/excluir{id}", name="contato_excluir")
     */

     public function excluir($id, EntityManagerInterface $em, ContatoRepository $contatoRepository) : Response
    {
        $contato = $contatoRepository->find($id);

        $em->remove($contato);
        $em->flush();

        return $this->redirectToRoute("contato_index");
    }
    }
