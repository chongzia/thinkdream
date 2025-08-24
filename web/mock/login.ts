import { MockMethod } from 'vite-plugin-mock'

export default [
  {
    url: '/api/login',
    method: 'post',
    response: ({ query }) => {
      return {
        code: 10000,
        data: {
          token: '151|Clodnw0fnYrDc1mBlRGjAnzG8VhlH9XiVtomNF7L'
        }
      }
    }
  },

  {
    url: '/api/logout',
    method: 'post',
    response: ({ query }) => {
      return {
        code: 10000,
        data: {
        }
      }
    }
  }
] as MockMethod[]
