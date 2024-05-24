import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RegistroArbitroComponent } from './registro-arbitro.component';

describe('RegistroArbitroComponent', () => {
  let component: RegistroArbitroComponent;
  let fixture: ComponentFixture<RegistroArbitroComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ RegistroArbitroComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(RegistroArbitroComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
