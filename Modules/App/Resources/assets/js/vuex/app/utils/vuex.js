export const set = property => (state, payload) => (state[property] = payload)

export const setStorage = property => (state, payload) => {
  state[property] = payload
  localStorage.setItem(property, payload)
}

export const toggle = property => state => (state[property] = !state[property])
