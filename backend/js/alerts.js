export function showAlert(message, type = "info", timeout = 3000) {
  const container = document.getElementById("alerts");
  if (!container) return;

  const alert = document.createElement("div");
  alert.className = `alert alert-${type} alert-dismissible fade show mt-3`;
  alert.role = "alert";
  alert.innerHTML = `
    ${message}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  `;

  container.appendChild(alert);

  setTimeout(() => alert.remove(), timeout);
}