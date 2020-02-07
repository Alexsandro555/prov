import axios from "axios/index"

export const api = {
  async get(url) {
    try {
      const {data} = await axios.get(url)
      return data
    } catch (error) {
      console.error(error)
    }
  },
  post(url, obj) {
    return new Promise((resolve, reject) => {
      axios.post(url, obj).then(response => response.data).then(response => {
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  patch({data, url}) {
    return new Promise((resolve, reject) => {
      axios.patch(url, data).then(response => response.data).then(response => {
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  delete({url, id}) {
    return new Promise((resolve, reject) => {
      axios.delete(url, {params: {id}})
        .then(response => response.data)
        .then(response => {
          resolve(response)
        }).catch(error => {
        reject(error)
      })
    })
  }
}