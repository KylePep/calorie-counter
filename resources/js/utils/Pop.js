import Swal from 'sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

export default class Pop {
  /**
 *
 * @param {string} title The title text.
 * @param {string} text The body text.
 * @param {string} confirmButtonText The text of your confirm button.
 * @param {'success' | 'error' | 'info' | 'warning' | 'question'} icon Pop icon
 *
 * {@link https://sweetalert2.github.io/#configuration|Check out Sweet Alerts}
 */
  static async confirm(title = 'Are you sure?', text = "You won't be able to revert this!", confirmButtonText = 'Yes', icon = 'warning') {
    try {
      const res = await Swal.fire({
        title,
        text,
        icon,
        confirmButtonText,
        showCancelButton: true,
        reverseButtons: true,
        iconColor: 'rgb(var(--color-special))',
        color: 'rgb(var(--color-text-dark-text))',
        confirmButtonColor: 'rgb(var(--color-accent))',
        cancelButtonColor: 'rgb(var(--color-neutral))'
      })
      if (res.isConfirmed) {
        return true
      }
      return false
    } catch (error) {
      return false
    }
  }

  /**
 *
 * @param {string} title The title text
 * @param {'success' | 'error' | 'info' | 'warning' | 'question'} icon
 * @param {'top' | 'top-start' | 'top-end' | 'center' | 'center-start' | 'center-end' | 'bottom' | 'bottom-start' | 'bottom-end'} position
 * @param {number} timer Time in milliseconds.
 * @param {boolean} progressBar Show progress bar or not respectively.
 * -----------------------------------
 * {@link https://sweetalert2.github.io/#configuration|Check out Sweet Alerts}
 */
  static toast(title = 'Warning!', icon = 'warning', position = 'top-end', timer = 3000, progressBar = true) {
    Swal.fire({
      title,
      icon,
      iconColor: 'rgb(var(--color-accent))',
      position,
      timer,
      timerProgressBar: progressBar,
      toast: true,
      showConfirmButton: false
    })
  }

  /**
   * @param {import('axios').AxiosError | Error | String } Error An Error Object.
   * @param { String } eventTrigger Queryable trigger
   */
  static error(error, eventTrigger = '') {

    if (error.isAxiosError) {
      const { response } = error
      const errorObj = (response.data ? response.data.error : response.data) || { message: 'Invalid Request ' + response.status }
      if (!errorObj) {
        return this.toast(error.message)
      }
      this.toast(errorObj.message || errorObj.error || 'error')
    } else {
      this.toast(error.message || error, 'error')
    }
  }

  /**
   * @param { string } message The message to display. If not provided, will display a generic message.
   */
  static success(message = 'Success!') {
    this.toast(message, 'success')
  }
}
