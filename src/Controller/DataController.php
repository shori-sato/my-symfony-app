<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Person;

class DataController extends AbstractController
{
    /**
     * @Route("/find", name="find")
     */
    public function find(Request $request)
    {
        $formObj=new FindForm();

        $form=$this->createFormBuilder($formObj)
        ->add('find',TextType::class)
        ->add('save',SubmitType::class)
        ->getForm();

        if($request->getMethod()=='POST'){
            $form->handleRequest($request);
            $find_name=$form->getData()->getFind();
            $repository=$this->getDoctrine()->getRepository(Person::class);
            $result=$repository->findByName($find_name);

            /* $manager=$this->getDoctrine()->getManager();
            $query=$manager->createQuery("SELECT p FROM App\Entity\Person p WHERE p.name = '{$find_name}'");
            $result=$query->getResult(); */
        }
        else{
            $result=null;
        }

        return $this->render('data/find.html.twig',[
            'title'=>'nameでエンティティを検索する',
            'datas'=>$result,
            'form'=>$form->createView(),
        ]);
    }
/**
 * @Route("/find2/{id}",name="find2")
 */
    public function find2(Request $request,Person $person){
        return $this->render('data/find2.html.twig',[
            'title'=>'エンティティの自動フェッチ',
            'data'=>$person,
        ]
        );
    }

}
class FindForm{
    private $find;
    public function getFind(){
        return $this->find;
    }
    public function setFind($find){
        $this->find = $find;
    }

}
