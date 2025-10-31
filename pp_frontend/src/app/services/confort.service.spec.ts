import { TestBed } from '@angular/core/testing';

import { ConfortService } from './confort.service';

describe('ConfortService', () => {
  let service: ConfortService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ConfortService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
