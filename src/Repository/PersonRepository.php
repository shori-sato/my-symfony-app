<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function findByName($value){
        /* return $this->createQueryBuilder('p')
        ->where('p.name=?1')//プレースホルダを使って検索の条件を設定
        ->setParameter(1,$value)
        ->getQuery()//検索を実行するオブジェクトを取得
        ->getResult(); */

        /* return $this->createQueryBuilder('p')
        ->where('p.name like ?1')
        ->setParameter(1,'%'.$value.'%')
        ->getQuery()
        ->getResult(); */

        /* $attr=explode(',',$value);
        return $this->createQueryBuilder('p')
        ->where('p.name in (?1,?2)')
        ->setParameters([1=>$attr[0],2=>$attr[1]]) //setParameter「s」であることに注意
        ->getQuery()
        ->getResult(); */

        /* $array=explode(',',$value);
        $builder=$this->createQueryBuilder('p');
        return $builder->where($builder->expr()->in('p.name',$array))
        ->getQuery()
        ->getResult(); */

        $builder=$this->createQueryBuilder('p');
        return $builder->where($builder->expr()->like('p.name','?1'))
        ->orWhere($builder->expr()->like('p.mail','?2'))
        ->setParameters([1=>'%'.$value.'%',2=>'%'.$value.'%'])
        ->getQuery()
        ->getResult();
    }

    public function findByAge($value){
       /*  return $this->createQueryBuilder('p')
        ->where('p.age >= ?1')
        ->setParameter(1,$value)
        ->getQuery()
        ->getResult(); */

        $array=explode(',',$value);
        $builder=$this->createQueryBuilder('p');
        return $builder->where($builder->expr()->gte('p.age','?1'))
        ->andWhere($builder->expr()->lte('p.age','?2'))
        ->setParameters([1=>$array[0],2=>$array[1]])
        ->getQuery()
        ->getResult();
    }

    public function findAllWithSort(){
        return $this->createQueryBuilder('p')
        ->orderBy('p.age','ASC')
        ->setFirstResult(0)
        ->setMaxResults(3)
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * @return Person[] Returns an array of Person objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Person
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
