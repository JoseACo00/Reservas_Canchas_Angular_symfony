import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PostCanchaComponent } from './post-cancha.component';

describe('PostCanchaComponent', () => {
  let component: PostCanchaComponent;
  let fixture: ComponentFixture<PostCanchaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PostCanchaComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(PostCanchaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
