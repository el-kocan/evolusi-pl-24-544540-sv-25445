import { describe, expect, it } from 'vitest';
import { countCompletedTasks } from '../src/utils/task.js';

describe('countCompletedTasks', () => {
  it('counts only completed tasks', () => {
    expect(countCompletedTasks([
      { is_completed: true },
      { is_completed: false },
      { is_completed: true },
    ])).toBe(2);
  });
});
