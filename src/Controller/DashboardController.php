<?php
// src/Controller/LuckyController.php
namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\UserType;
use App\Entity\User;


class DashboardController extends Controller
{


    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
      $user = new User();
      $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
        $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

            // 4) save the User!
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

        return $this->redirectToRoute('login');
      }

      return $this->render(
        'dashboard/register.html.twig',
        array('form' => $form->createView())
      );
    }

    /**
     * @Route("/login", name="login")
     */
     public function login(Request $request, AuthenticationUtils $authUtils)
     {

            // get the login error if there is one
      $error = $authUtils->getLastAuthenticationError();

    // last username entered by the user
      $lastUsername = $authUtils->getLastUsername();

      return $this->render('dashboard/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
      ));

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
     
      return $this->render('dashboard/login.html.twig');
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
      return new Response('<html><body>Admin page!</body></html>');
    }
	  /**
     * @Route("/", name="home")
     */
    public function home()
    {

      return $this->render('dashboard/dashboard.html.twig');
    }

    /**
     * @Route("/user", name="user")
     */ 
    public function user()
    {

      return $this->render('dashboard/user.html.twig');
    }


    /**
     * @Route("/maps", name="maps")
     */
    public function maps()
    {

      return $this->render('dashboard/maps.html.twig');
    }


    /**
     * @Route("/table", name="table")
     */
    public function table()
    {

      return $this->render('dashboard/table.html.twig');
    }

    /**
     * @Route("/notifications", name="notifications")
     */
    public function notifications()
    {

      return $this->render('dashboard/notifications.html.twig');
    }


    /**
     * @Route("/typography", name="typography")
     */
    public function typography()
    {

      return $this->render('dashboard/typography.html.twig');
    }

    /**
     * @Route("/icons", name="icons")
     */
    public function icons()
    {

      return $this->render('dashboard/icons.html.twig');
    }

    /**
     * @Route("/upgrade", name="upgrade")
     */
    public function upgrade()
    {

      return $this->render('dashboard/upgrade.html.twig');
     } 



}
?>