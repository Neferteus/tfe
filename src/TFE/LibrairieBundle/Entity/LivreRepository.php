<?php

namespace TFE\LibrairieBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * LivreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LivreRepository extends EntityRepository
{
    public function countAll()
    {
        return $this->createQueryBuilder('l')
            ->select('COUNT(l)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countPromo()
    {
        return $this->createQueryBuilder('l')
            ->select('COUNT(l)')
            ->where('l.ristourne > 0')
            ->orderBy('l.ristourne', 'DESC')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countAllById($id)
    {
        return $this->createQueryBuilder('l')
            ->select('COUNT(l)')
            ->where('l.categorie = :id')
                ->setParameter('id', $id)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getListeComplete($page, $maxParPage)
    {
        $qb = $this
            ->createQueryBuilder('l')
            ->leftJoin('l.edition', 'edi')
            ->addSelect('edi')
            ->leftJoin('l.collection', 'col')
            ->addSelect('col')
            ->leftJoin('l.format', 'for')
            ->addSelect('for')
            ->leftJoin('l.categorie', 'cat')
            ->addSelect('cat')
            ->leftJoin('l.auteurs', 'aut')
            ->addselect('aut')
            ->leftJoin('l.accompagnements', 'acc')
            ->addSelect('acc')
            ->setFirstResult(($page-1) * $maxParPage)
            ->setMaxResults($maxParPage)
            ->orderBy('l.titre')
        ;

        return new Paginator($qb);
    }

    public function getListeCompleteById($page, $maxParPage, $id)
    {
        $qb = $this
            ->createQueryBuilder('l')
            ->leftJoin('l.edition', 'edi')
            ->addSelect('edi')
            ->leftJoin('l.collection', 'col')
            ->addSelect('col')
            ->leftJoin('l.format', 'for')
            ->addSelect('for')
            ->leftJoin('l.categorie', 'cat')
            ->addSelect('cat')
            ->leftJoin('l.auteurs', 'aut')
            ->addselect('aut')
            ->leftJoin('l.accompagnements', 'acc')
            ->addSelect('acc')
            ->where('l.categorie = :id')
            ->setParameter('id', $id)
            ->setFirstResult(($page-1) * $maxParPage)
            ->setMaxResults($maxParPage)
            ->orderBy('l.titre')
        ;

        return new Paginator($qb);
    }

    public function getLivreCompletParId($id)
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.edition', 'edi')
            ->addSelect('edi')
            ->leftJoin('l.collection', 'col')
            ->addSelect('col')
            ->leftJoin('l.format', 'for')
            ->addSelect('for')
            ->leftJoin('l.categorie', 'cat')
            ->addSelect('cat')
            ->leftJoin('cat.genre', 'gen')
            ->addSelect('gen')
            ->leftJoin('l.auteurs', 'aut')
            ->addselect('aut')
            ->leftJoin('l.accompagnements', 'acc')
            ->addSelect('acc')
            ->leftJoin('l.commentaires', 'com', 'WITH', 'com.blocageCom = false')
            ->addSelect('com')
            ->leftJoin('l.notes', 'note')
            ->addSelect('note')
            ->where('l.id = :id')
                ->setParameter('id', $id)
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getListeAffiche()
    {
        return $this->createQueryBuilder('l')
            ->where('l.teteAffiche = true')
            ->leftJoin('l.edition', 'edi')
            ->addSelect('edi')
            ->leftJoin('l.accompagnements', 'acc')
            ->addSelect('acc')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function getListeBestSale()
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.edition', 'edi')
            ->addSelect('edi')
            ->leftJoin('l.accompagnements', 'acc')
            ->addSelect('acc')
            ->where('l.nbrVente > 0')
            ->orderBy('l.nbrVente', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function getListeNouveau()
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.edition', 'edi')
            ->addSelect('edi')
            ->leftJoin('l.accompagnements', 'acc')
            ->addSelect('acc')
            ->where('l.aVenir = true')
            ->orderBy('l.anneeParution', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function getPromotion()
    {
        return $this->createQueryBuilder('l')
            ->where('l.ristourne > 0')
            ->leftjoin('l.edition', 'edi')
            ->addSelect('edi')
            ->leftJoin('l.accompagnements', 'acc')
            ->addSelect('acc')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function getListePromo($page, $maxParPage)
    {
        $qb = $this
            ->createQueryBuilder('l')
            ->leftJoin('l.edition', 'edi')
            ->addSelect('edi')
            ->leftJoin('l.collection', 'col')
            ->addSelect('col')
            ->leftJoin('l.format', 'for')
            ->addSelect('for')
            ->leftJoin('l.categorie', 'cat')
            ->addSelect('cat')
            ->leftJoin('l.auteurs', 'aut')
            ->addselect('aut')
            ->leftJoin('l.accompagnements', 'acc')
            ->addSelect('acc')
            ->where('l.ristourne > 0')
            ->setFirstResult(($page-1) * $maxParPage)
            ->setMaxResults($maxParPage)
            ->orderBy('l.titre')
        ;

        return new Paginator($qb);
    }

    public function listeCommande()
    {
        return $this->createQueryBuilder('l')
            ->where('l.stock < l.seuilAlerte')
            ->getQuery()
            ->getResult();
    }

    public function listeRecherche($valeur)
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.edition', 'edi')
            ->addSelect('edi')
            ->leftJoin('l.collection', 'col')
            ->addSelect('col')
            ->leftJoin('l.format', 'for')
            ->addSelect('for')
            ->leftJoin('l.categorie', 'cat')
            ->addSelect('cat')
            ->leftJoin('cat.genre', 'gen')
            ->addSelect('gen')
            ->leftJoin('l.auteurs', 'aut')
            ->addselect('aut')
            ->leftJoin('l.accompagnements', 'acc')
            ->addSelect('acc')
            ->leftJoin('l.commentaires', 'com', 'WITH', 'com.blocageCom = false')
            ->addSelect('com')
            ->leftJoin('l.notes', 'note')
            ->addSelect('note')
            ->where('l.titre LIKE :valeur')
            ->orWhere('l.soustitre LIKE :valeur')
            ->setParameter('valeur', '%' . $valeur . '%')
            ->orderBy('l.titre')
            ->getQuery()
            ->getResult();
    }
}
