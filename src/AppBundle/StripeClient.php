<?php

namespace AppBundle;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class StripeClient {
  private $em;
  
  public function __construct(EntityManager $em) {
    $this->em = $em;
  }


  public function createCustomer(User $user, $paymentToken){
    $customer = \Stripe\Customer::create([
      'email' => $user->getEmail(),
      'source' => $paymentToken  
    ]);
    $user->setStripeCustomerId($customer->id);
    $em = $this->em;
    $em->persist($user);
    $em->flush();
    
    return $customer;
  }
}
