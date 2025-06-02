import { fetchApi } from "./fetch.js";
import { visual } from "./visual.js";
import { state } from "./state.js";
import { filterAndSortTasks } from "./filter.js";
import { showAlert } from "./alerts.js";


async function loadAndRender() {
  try {
    if (state.tasks.length === 0) {
      state.tasks = await fetchApi.getTasks();
    }
    const filtered = filterAndSortTasks(state.tasks);
    visual.renderTasks(filtered);
  } catch {
    showAlert("Erro ao carregar tarefas.", "danger");
  }
}

async function refreshTasks() {
  try {
    state.tasks = await fetchApi.getTasks();
    await loadAndRender();
  } catch {
    showAlert("Erro ao atualizar tarefas.", "danger");
  }
}

document.addEventListener("DOMContentLoaded", async () => {

  const token = localStorage.getItem("jwt_token");
  if (!token || token.split('.').length !== 3) {
    localStorage.removeItem("jwt_token");
    window.location.href = "login.html";
    throw new Error("Token inválido ou ausente");
  }

  await loadAndRender();
  visual.bindFilterAndSortControls(loadAndRender);

  const taskForm = document.getElementById("task-form");
  if (taskForm) {
    taskForm.addEventListener("submit", async (event) => {
      event.preventDefault();
      const title = document.getElementById("title").value.trim();
      const description = document.getElementById("description").value.trim();
      const status = document.getElementById("status").value;

      if (!title || !description || !status) {
        showAlert("Preencha todos os campos!", "warning");
        return;
      }

      try {
        await fetchApi.createTask({ title, description, status });
        await refreshTasks();
        event.target.reset();
        showAlert("Tarefa criada com sucesso!", "success");
      } catch {
        showAlert("Erro ao criar tarefa.", "danger");
      }
    });
  }

  const editForm = document.getElementById("edit-form");
  if (editForm) {
    editForm.addEventListener("submit", async (event) => {
      event.preventDefault();
      const id = document.getElementById("edit-id").value;
      const title = document.getElementById("edit-title").value.trim();
      const description = document.getElementById("edit-description").value.trim();
      const status = document.getElementById("edit-status").value;

      if (!title || !description || !status) {
        showAlert("Todos os campos são obrigatórios!", "warning");
        return;
      }

      try {
        await fetchApi.updateTask(id, { title, description, status });
        await refreshTasks();
        showAlert("Tarefa atualizada!", "info");
      } catch {
        showAlert("Erro ao atualizar tarefa.", "danger");
      }
    });
  }

  const confirmDeleteBtn = document.getElementById("confirm-delete");
  if (confirmDeleteBtn) {
    confirmDeleteBtn.addEventListener("click", async () => {
      const id = document.getElementById("delete-id").value;
      try {
        await fetchApi.deleteTask(id);
        await refreshTasks();
        showAlert("Tarefa removida!", "danger");
      } catch {
        showAlert("Erro ao excluir tarefa.", "danger");
      }
    });
  }
});
