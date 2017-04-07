<?php

namespace AppBundle;

use AppBundle\Entity\User;

class StripeClient {
  public function createCustomer(User $user, $paymentToken){
    $customer = \Stripe\Customer::create([
      'email' => $user->getEmail(),
      'source' => $paymentToken  
    ]);
    $user->setStripeCustomerId($customer->id);
    $em = $this->getDoctrine()->getManager();
    $em->persist($user);
    $em->flush();
    
    return $customer;
  }
}
