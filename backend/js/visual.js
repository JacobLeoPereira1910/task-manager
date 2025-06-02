import { state } from "./state.js";

export const visual = {
  renderTasks(data) {
    const tbody = document.querySelector("tbody");
    tbody.innerHTML = "";

    data.forEach(item => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${item.id}</td>
        <td>${item.title}</td>
        <td>${item.description}</td>
        <td><span class="badge bg-${this.statusColor(item.status)}">${item.status}</span></td>
        <td>${new Date(item.created_at).toLocaleString()}</td>
        <td>
          <button class="btn btn-sm btn-primary" data-edit='${JSON.stringify(item)}' data-bs-toggle="modal" data-bs-target="#modal-edit"><i class="fa-solid fa-pen-to-square"></i></button>
          <button class="btn btn-sm btn-danger" data-delete='${item.id}' data-bs-toggle="modal" data-bs-target="#modal-delete"><i class="fa-solid fa-trash-can"></i></button>
        </td>
      `;
      tbody.appendChild(row);
    });

    this.bindButtons();
    this.highlightSortedColumn();
  },

  statusColor(status) {
    switch (status) {
      case "pendente": return "warning";
      case "em andamento": return "info";
      case "concluída": return "success";
      default: return "dark";
    }
  },

  bindButtons() {
    document.querySelectorAll("[data-edit]").forEach(item => {
      item.addEventListener("click", () => {
        const task = JSON.parse(item.dataset.edit);
        document.getElementById("edit-id").value = task.id;
        document.getElementById("edit-title").value = task.title;
        document.getElementById("edit-description").value = task.description;
        document.getElementById("edit-status").value = task.status;
      });
    });

    document.querySelectorAll("[data-delete]").forEach(item => {
      item.addEventListener("click", () => {
        document.getElementById("delete-id").value = item.dataset.delete;
      });
    });
  },

  bindFilterAndSortControls(callback) {
    const searchInput = document.getElementById("search");
    const statusSelect = document.getElementById("filter-status");
    const clearBtn = document.getElementById("clear-filters");
    const sortableHeaders = document.querySelectorAll("th[data-sort]");

    if (!searchInput || !statusSelect || !clearBtn || sortableHeaders.length === 0) {
      return;
    }

    searchInput.addEventListener("input", event => {
      state.filter.searchText = event.target.value.toLowerCase();
      callback();
    });

    statusSelect.addEventListener("change", event => {
      state.filter.status = event.target.value;
      callback();
    });

    clearBtn.addEventListener("click", event => {
      event.preventDefault();
      searchInput.value = "";
      statusSelect.value = "";
      state.filter.searchText = "";
      state.filter.status = "";
      callback();
    });

    sortableHeaders.forEach(item => {
      item.style.cursor = "pointer";
      item.addEventListener("click", () => {
        const sortBy = item.getAttribute("data-sort");
        if (state.filter.sortBy === sortBy) {
          state.filter.sortDir = state.filter.sortDir === "asc" ? "desc" : "asc";
        } else {
          state.filter.sortBy = sortBy;
          state.filter.sortDir = "asc";
        }
        callback();
      });
    });
  },

  highlightSortedColumn() {
    const sortableHeaders = document.querySelectorAll("th[data-sort]");
    sortableHeaders.forEach(item => {
      item.classList.remove("table-primary");
      item.querySelector("i").className = "";
      if (item.getAttribute("data-sort") === state.filter.sortBy) {
        item.classList.add("table-primary");
        if (state.filter.sortDir === "asc") {
          item.querySelector("i").className = "fa-solid fa-sort-up";
        } else {
          item.querySelector("i").className = "fa-solid fa-sort-down";
        }
      }
    });
  },
};
