;;; dev-env.el --- Project-local development dependencies -*- lexical-binding: t; -*-

;;; Commentary:

;; Cask normally supplies the package load path.  Batch builds and tests can
;; also use its installed dependencies without the Cask executable.  Keep each
;; Emacs version's package environment separate, including Emacs 31.1.

;;; Code:

(require 'package)
(require 'ert)

(let* ((helper-file (or load-file-name (buffer-file-name)))
       (project-root (locate-dominating-file helper-file "Cask"))
       (local-elpa
        (and project-root
             (expand-file-name
              (format ".cask/%d.%d/elpa"
                      emacs-major-version emacs-minor-version)
              project-root))))
  (when (and local-elpa (file-directory-p local-elpa))
    (setq package-user-dir local-elpa)
    ;; Older installations may still contain ert-runner after it was removed
    ;; from Cask.  Its generated autoloads evaluate the legacy `defmacro*' and
    ;; replace built-in ERT definitions.  Use Emacs's ERT without activating it.
    (let ((package-load-list
           (cons '(ert-runner nil)
                 (assq-delete-all 'ert-runner
                                  (copy-tree package-load-list)))))
      (package-initialize))))

(provide 'ac-php-dev-env)
;;; dev-env.el ends here
