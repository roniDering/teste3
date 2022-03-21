<?php

namespace App\Controller;

use App\Entity\Pessoa;
use App\Form\PessoaType;
use App\Repository\PessoaRepository;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PessoaController extends AbstractController
{
    /**
     * @Route("/pessoa",name="pessoa_index")
     */

    public function index(PessoaRepository $pessoaRepository) : Response
    {
        $pessoaPesquisada="";
         $pessoaPesquisada = isset( $_GET['nomePesquisado']);  //recebe via GET nome pesquisado
        $data['titulo'] = "Tabela Pessoas";
        echo"$pessoaPesquisada";
        if($pessoaPesquisada==""){   //verifica se foi pesquisado         
            $data['pessoas'] = $pessoaRepository->findAll(); //procura no bd toda as pessoas
            return $this->renderForm('pessoa/index.html.twig',$data);

        }else{
            $data['pessoas'] = $pessoaRepository->findAll('nome',''); //filtra conforme a pesquisa
            return $this->renderForm('pessoa/index.html.twig',$data);
            
        }
    }

    /**
     * @Route("/pessoa/adicionar",name="pessoa_adicionar")
     */
    public function adicionar(Request $request, EntityManagerInterface $em) : Response{
        //request pega os dados do formulario
        //$em gerencia atraves da orm para inserir dados no bd
        $msg="";
        $pessoa = new Pessoa();
        $form = $this->createForm(PessoaType::class, $pessoa);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){ //validação de form
            //salvar no bd
            $em->persist($pessoa);  //salva na memoria
            $em->flush();  //executa e salva no bd
            $msg="Pessoa cadastrada com sucesso!";
        }
        $data['titulo'] = 'Adicionar nova Pessoa';
        $data['form'] = $form;
        $data['msg'] = $msg;
        return $this->renderForm('pessoa/form.html.twig',$data);
    }

     /**
     * @Route("/pessoa/editar/{id}",name="pessoa_editar")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, PessoaRepository $pessoaRepository) : Response
    {
        $msg="";
        $pessoa = $pessoaRepository->find($id);  //retorna o id
        $form = $this->createForm(PessoaType::class, $pessoa);
         $form->handleRequest($request);

         if($form->isSubmitted()&& $form->isValid()){
             $em->Flush();
             $msg="Editado com sucesso!";
         }
         $data['titulo'] = 'Editar Pessoa';
         $data['form'] = $form;
         $data['msg'] = $msg;
         return $this->renderForm('pessoa/form.html.twig',$data);

    }

    /**
     * @Route("/pessoa/excluir/{id}",name="pessoa_excluir")
     */
    public function excluir($id, EntityManagerInterface $em, PessoaRepository $pessoaRepository) : Response
    {
        $pessoa = $pessoaRepository->find($id);
        $em->remove($pessoa);
        $em->flush();
        
        //depois que exclui ele volta pro index
        return $this->redirectToRoute('pessoa_index');
    }

    

}