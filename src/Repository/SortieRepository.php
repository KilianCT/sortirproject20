<?php

namespace App\Repository;

use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Sortie $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Sortie $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Sortie[] Returns an array of Sortie objects
     */
    public function findByChamps($recherche, $selectSite, $dateMin, $dateMax, $utilisateur, $isOrganisateur, $isSortiePasse, $etat)
    {
        $organisateurEgal = 's.organisateur = :val5';
        $organisateurPasEgal = 's.organisateur != :val5';
        $etatPasse = 's.etat = :val6';
        $etatPasPasse = 's.etat != :val6';

        if ($isOrganisateur){
            $string5 = $organisateurEgal;
            $param5=$utilisateur;
        }else{
            $string5 = $organisateurPasEgal;
            $param5 = 0;
        }

        if ($isSortiePasse){
            $string6 = $etatPasse;
        }else{
            $string6 = $etatPasPasse;
        }

        return $this->createQueryBuilder('s')
            ->andWhere('s.nom LIKE :val1')
            ->setParameter('val1', '%' . $recherche . '%')
            ->andWhere('s.site_no_site = :val2')
            ->setParameter('val2', $selectSite)
            ->andWhere('s.dateHeureDebut >= :val3')
            ->setParameter('val3', $dateMin)
            ->andWhere('s.dateHeureDebut <= :val4')
            ->setParameter('val4', $dateMax)
            ->andWhere($string5)
            ->setParameter('val5', $param5)
            ->andWhere($string6)
            ->setParameter('val6', $etat)
                ->orderBy('s.id', 'ASC')
                ->getQuery()
                ->getResult();
    }




    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
