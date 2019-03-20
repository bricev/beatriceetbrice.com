import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { HoneymoonCancelComponent } from './honeymoon-cancel.component';

describe('HoneymoonCancelComponent', () => {
  let component: HoneymoonCancelComponent;
  let fixture: ComponentFixture<HoneymoonCancelComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ HoneymoonCancelComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(HoneymoonCancelComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
