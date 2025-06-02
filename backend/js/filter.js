import { state } from "./state.js";

export function filterAndSortTasks(data) {
  let filtered = data;

  if (state.filter.status) {
    filtered = filtered.filter(task => task.status === state.filter.status);
  }

  if (state.filter.searchText) {
    filtered = filtered.filter(task =>
      task.title.toLowerCase().includes(state.filter.searchText) ||
      task.description.toLowerCase().includes(state.filter.searchText)
    );
  }

  filtered.sort((a, b) => {
    const key = state.filter.sortBy;
    let valA = a[key];
    let valB = b[key];

    if (key === "created_at") {
      valA = new Date(valA);
      valB = new Date(valB);
    }

    if (typeof valA === "string") valA = valA.toLowerCase();
    if (typeof valB === "string") valB = valB.toLowerCase();

    if (valA < valB) return state.filter.sortDir === "asc" ? -1 : 1;
    if (valA > valB) return state.filter.sortDir === "asc" ? 1 : -1;
    return 0;
  });

  return filtered;
}
