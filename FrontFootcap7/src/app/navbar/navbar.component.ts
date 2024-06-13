import { Component } from '@angular/core';
import { LoginService } from '../services/Loggin/login.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent {

  isLoggedIn: boolean = false;
  isAdmin: boolean = false;
  isUser: boolean = false;
  isArbitro: boolean = false;
  constructor(private loginService: LoginService,  private router: Router) { }

  ngOnInit(): void {
    this.isLoggedIn = this.loginService.isLoggedIn();
    if (this.isLoggedIn) {
      const role = this.loginService.getUserRole();
      this.isUser = role === 'Usuario';
      this.isAdmin = role === 'Admin';
      this.isArbitro = role === 'Arbitro';
    }
  }

  logout(): void {
    this.loginService.logout();
    this.router.navigate(['/Login']);
  }
}
