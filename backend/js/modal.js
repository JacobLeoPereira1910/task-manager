export function bindEditModal(item) {
  document.getElementById("edit-id").value = item.id;
  document.getElementById("edit-title").value = item.title;
  document.getElementById("edit-description").value = item.description;
  document.getElementById("edit-status").value = item.status;
}

export function bindDeleteModal(id) {
  document.getElementById("delete-id").value = id;
}
