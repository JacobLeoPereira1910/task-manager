const url = "http://localhost:9000/tasks";

function getToken() {
  return localStorage.getItem("jwt_token") || "";
}

async function handlerResponse(response) {
  if (!response.ok) {
    if (response.status === 401) {
      localStorage.removeItem("jwt_token");
      window.location.href = "login.html";
      throw new Error("Sua sessão expirou. Faça login novamente.");
    }
    let msg = `Erro inesperado (${response.status})`;
    try {
      const data = await response.json();
      if (data.message) msg = data.message;
    } catch {
    throw new Error(msg);
    }
    
  }
  return response.json();
}

export const fetchApi = {
  async getTasks() {
    const res = await fetch(url, {
      headers: { Authorization: `Bearer ${getToken()}` },
    });
    const data = await handlerResponse(res);
    return data.data;
  },

  async createTask(data) {
    const res = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify(data),
    });
    return handlerResponse(res);
  },

  async updateTask(id, data) {
    const res = await fetch(`${url}/${id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify(data),
    });
    return handlerResponse(res);
  },

  async deleteTask(id) {
    const res = await fetch(`${url}/${id}`, {
      method: "DELETE",
      headers: { Authorization: `Bearer ${getToken()}` },
    });
    return handlerResponse(res);
  },
};
