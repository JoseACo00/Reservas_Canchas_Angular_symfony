import { Injectable, inject } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot, UrlTree } from '@angular/router';
import { Observable } from 'rxjs';


export const LogginGuard = () => {
  const router = inject(Router)

  //Saber si tiene el jwt
  if (localStorage.getItem('TokenJWT')|| sessionStorage.getItem('TokenJWT')){
    return true;
  } else {
      // RETORMANOS A LA PAGINA QUE QUERAMOS
      router.navigate(['Login']);
    return false;
  }


  //Para saber que tiene el rol admin


  //Para saber que tiene rol Usuario

  //Para saber que tiene rol arbitro

}
