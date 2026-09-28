export function countCompletedTasks(tasks) {
  return tasks.filter((task) => task.is_completed).length;
}
