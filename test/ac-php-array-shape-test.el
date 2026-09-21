;;; ac-php-array-shape-test.el --- Array shape completion tests -*- lexical-binding: t; -*-

;;; Commentary:

;; Exercise PHPStan array-shape key completion.

;;; Code:

(defun ac-php-test--array-shape-candidates (content &optional frontend tags-data)
  "Complete CONTENT at |CURSOR| using FRONTEND and TAGS-DATA."
  (with-ac-php-buffer-test content
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let ((tags (or tags-data
                    (list (make-hash-table :test #'equal)
                          (make-hash-table :test #'equal)
                          (make-hash-table :test #'equal)
                          [] "/project/")))
          (pos (point)))
      (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags)))
        (prog1
            (mapcar
             #'substring-no-properties
             (cond
              ((eq frontend 'company) (company-ac-php-candidate ""))
              ((eq frontend 'auto-complete)
               (let ((ac-prefix (company-ac-php--prefix-symbol)))
                 (ac-php-candidate-ac)))
              (t (ac-php-candidate))))
          (should (= (point) pos)))))))

(defconst ac-php-test--array-shape-method-body
  "
private function get_user_device($voice_device_id)
{
    return $this->db_card->t_voice_device->field_get_list([]);
}")

(defconst ac-php-test--array-shape-parameter-doc
  "/**
 * @param int $voice_device_id
 *
 * @param array{
 *   voice_device_id: int,
 *   sn: string,
 *   api_user_id: int,
 *   card_device_type: int,
 *   net_type: int|null
 * }|false $data
 */")

(defconst ac-php-test--user-device-keys
  '("voice_device_id" "sn" "api_user_id" "card_device_type" "net_type"))

(ert-deftest ac-php-array-shape/phpstan-alias-return-completes-keys ()
  (let ((content
         (concat
          "<?php\n/**\n"
          " * @phpstan-type UserDevice array{\n"
          " *   voice_device_id: int,\n"
          " *   sn: string,\n"
          " *   api_user_id: int,\n"
          " *   card_device_type: int,\n"
          " *   net_type: int|null\n"
          " * }\n"
          " */\nclass Test {\n"
          "/** @return UserDevice|false */"
          ac-php-test--array-shape-method-body
          "\npublic function run() {\n"
          "  $device = $this->get_user_device(100);\n"
          "  $value = $device[\"|CURSOR|\"];\n}\n}")))
    (dolist (frontend '(core company auto-complete))
      (should
       (equal (ac-php-test--array-shape-candidates content frontend)
              '("voice_device_id" "sn" "api_user_id"
                "card_device_type" "net_type"))))))

(ert-deftest ac-php-array-shape/inline-multiline-return-completes-keys ()
  (let ((content
         (concat
          "<?php\nclass Test {\n"
          "/**\n"
          " * @param int $voice_device_id\n"
          " *\n"
          " * @return array{\n"
          " *   voice_device_id: int,\n"
          " *   sn: string,\n"
          " *   api_user_id: int,\n"
          " *   card_device_type: int,\n"
          " *   net_type: int|null\n"
          " * }|false\n"
          " */"
          ac-php-test--array-shape-method-body
          "\npublic function run() {\n"
          "  $device = $this->get_user_device(100);\n"
          "  $value = $device['|CURSOR|'];\n}\n}")))
    (should
     (equal (ac-php-test--array-shape-candidates content)
            '("voice_device_id" "sn" "api_user_id"
              "card_device_type" "net_type")))))

(ert-deftest ac-php-array-shape/prefix-and-field-metadata ()
  (with-ac-php-buffer-test
      (concat
       "<?php\nclass Test {\n"
       "/** @return array{voice_device_id: int, sn?: string}|false */"
       ac-php-test--array-shape-method-body
       "\npublic function run() {\n"
       "  $device = $this->get_user_device(100);\n"
       "  $value = $device[\"vo|CURSOR|\"];\n}\n}")
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let* ((tags (list (make-hash-table :test #'equal)
                       (make-hash-table :test #'equal)
                       (make-hash-table :test #'equal)
                       [] "/project/"))
           (context (ac-php--array-key-context))
           (candidates (ac-php-candidate-array-key tags context))
           (voice-id (car candidates)))
      (should (equal (plist-get context :prefix) "vo"))
      (should (equal (mapcar #'substring-no-properties candidates)
                     '("voice_device_id" "sn")))
      (should (equal (get-text-property 0 'ac-php-return-type voice-id)
                     "int"))
      (should (equal (company-ac-php--prefix) '("vo" . t))))))

(ert-deftest ac-php-array-shape/nested-alias-completes-inner-keys ()
  (let ((content
         (concat
          "<?php\n/**\n"
          " * @phpstan-type Profile array{name: string, enabled: bool}\n"
          " * @phpstan-type User array{id: int, profile: Profile}\n"
          " */\nclass Test {\n"
          "/** @return User */\nprivate function get_user() {}\n"
          "public function run() {\n"
          "  $user = $this->get_user();\n"
          "  $value = $user[\"profile\"][\"|CURSOR|\"];\n}\n}")))
    (should (equal (ac-php-test--array-shape-candidates content)
                   '("name" "enabled")))))

(ert-deftest ac-php-array-shape/phpdoc-parameter-completes-inside-function ()
  (let ((content
         (concat
          "<?php\nclass Test {\n"
          ac-php-test--array-shape-parameter-doc
          "\nprivate function set_user_device($voice_device_id, $data) {\n"
          "  $value = $data[\"|CURSOR|\"];\n}\n}")))
    (dolist (frontend '(core company auto-complete))
      (should
       (equal (ac-php-test--array-shape-candidates content frontend)
              ac-php-test--user-device-keys)))))

(ert-deftest ac-php-array-shape/local-var-completes-keys ()
  (let ((content
         (concat
          "<?php\nfunction run() {\n"
          "  /**\n"
          "   @var  array{ id: int } $item\n"
          "   */\n"
          "  $item = [\"id\" => 1];\n"
          "  $value = $item[\"|CURSOR|\"];\n"
          "}")))
    (dolist (frontend '(core company auto-complete))
      (should
       (equal (ac-php-test--array-shape-candidates content frontend)
              '("id"))))))

(ert-deftest ac-php-array-shape/local-var-list-element-completes-keys ()
  (let ((content
         (concat
          "<?php\nfunction run() {\n"
          "  /** @var array{\n"
          "   *   code: int,\n"
          "   *   info: string,\n"
          "   *   request_id: string,\n"
          "   *   data?: array{\n"
          "   *     list: list<array{\n"
          "   *       content: string,\n"
          "   *       content_type: int,\n"
          "   *       id: int,\n"
          "   *       sub_type_1: int,\n"
          "   *       sub_type_2: int,\n"
          "   *       distance: float\n"
          "   *     }>\n"
          "   *   }\n"
          "   * } $ret */\n"
          "  $ret[\"data\"][\"list\"][0][\"|CURSOR|\"];\n"
          "}")))
    (dolist (frontend '(core company auto-complete))
      (should
       (equal (ac-php-test--array-shape-candidates content frontend)
              '("content" "content_type" "id" "sub_type_1"
                "sub_type_2" "distance"))))))

(ert-deftest ac-php-array-shape/assigned-list-element-completes-keys ()
  (let ((content
         (concat
          "<?php\nfunction run() {\n"
          "  /** @var array{data: array{list: list<array{\n"
          "   * content: string, content_type: int, id: int,\n"
          "   * sub_type_1: int, sub_type_2: int, distance: float\n"
          "   * }>}} $ret */\n"
          "  $item = $ret[\"data\"][\"list\"][0];\n"
          "  $item[\"|CURSOR|\"];\n"
          "}")))
    (dolist (frontend '(core company auto-complete))
      (should
       (equal (ac-php-test--array-shape-candidates content frontend)
              '("content" "content_type" "id" "sub_type_1"
                "sub_type_2" "distance"))))))

(ert-deftest ac-php-array-shape/foreach-coalesced-list-completes-keys ()
  (let ((content
         (concat
          "<?php\nfunction run() {\n"
          "  /** @var array{data: array{list: list<array{\n"
          "   * content: string, content_type: int, id: int,\n"
          "   * sub_type_1: int, sub_type_2: int, distance: float\n"
          "   * }>}} $ret */\n"
          "  $list = $ret[\"data\"][\"list\"] ?? [];\n"
          "  foreach ($list as $item) {\n"
          "    $item[\"|CURSOR|\"];\n"
          "  }\n"
          "}")))
    (dolist (frontend '(core company auto-complete))
      (should
       (equal (ac-php-test--array-shape-candidates content frontend)
              '("content" "content_type" "id" "sub_type_1"
                "sub_type_2" "distance"))))))

(ert-deftest ac-php-array-shape/bare-offset-does-not-trigger-key-completion ()
  (with-ac-php-buffer-test
      (concat
       "<?php\nfunction run() {\n"
       "  /** @var array{id: int} $item */\n"
       "  $item[|CURSOR|];\n"
       "}")
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (should-not (ac-php--array-key-context))))

(ert-deftest ac-php-array-shape/phpdoc-parameter-completes-call-array ()
  (let ((content
         (concat
          "<?php\nclass Test {\n"
          ac-php-test--array-shape-parameter-doc
          "\nprivate function set_user_device($voice_device_id, $data) {}\n"
          "public function run() {\n"
          "  $voice_device_id = 100;\n"
          "  $this->set_user_device($voice_device_id, [\n"
          "    \"net_type\" => 1,\n"
          "    \"api_user_id\" => 1,\n"
          "    \"|CURSOR|\"\n"
          "  ]);\n}\n}")))
    (dolist (frontend '(core company auto-complete))
      (should
       (equal (ac-php-test--array-shape-candidates content frontend)
              '("voice_device_id" "sn" "card_device_type"))))))

(ert-deftest ac-php-array-shape/call-array-does-not-complete-value-string ()
  (let ((content
         (concat
          "<?php\nclass Test {\n"
          ac-php-test--array-shape-parameter-doc
          "\nprivate function set_user_device($voice_device_id, $data) {}\n"
          "public function run() {\n"
          "  $this->set_user_device(100, [\"sn\" => \"|CURSOR|\"]);\n"
          "}\n}")))
    (should-not (ac-php-test--array-shape-candidates content))))

(ert-deftest ac-php-array-shape/phpdoc-method-union-shapes-complete-first-argument ()
  (let ((content
         (concat
          "<?php\n/**\n"
          " * @method int field_update_list("
          "int|array{voice_device_id: int}|array{sn: string} $id, "
          "array{tenant_id?: int} $fields)\n"
          " */\nclass Test {\npublic function run() {\n"
          "  $this->field_update_list([\"|CURSOR|\"], []);\n"
          "}\n}")))
    (should
     (equal (ac-php-test--array-shape-candidates content)
            '("voice_device_id" "sn")))))

(ert-deftest ac-php-array-shape/phpdoc-method-generic-tail-completes-second-argument ()
  (let ((content
         (concat
          "<?php\n/**\n"
          " * @method int field_update_list("
          "int|array{voice_device_id: int}|array{sn: string} $id, "
          "array{tenant_id?: int, net_type?: int|null, "
          "card_device_type?: int, "
          "...<int, string|array{0: string, 1: mixed, "
          "2?: '+'|'-'}>} $fields)\n"
          " */\nclass Test {\npublic function run() {\n"
          "  $this->field_update_list(1, [\n"
          "    \"tenant_id\" => 1,\n"
          "    \"|CURSOR|\"\n"
          "  ]);\n}\n}")))
    (should
     (equal (ac-php-test--array-shape-candidates content)
            '("net_type" "card_device_type")))))

(ert-deftest ac-php-array-shape/mago-typed-member-arguments-complete-cross-file-method ()
  (let* ((class "\\Gen\\Models\\DbCard\\BVoiceDevice")
         (class-map (make-hash-table :test #'equal))
         (function-map (make-hash-table :test #'equal))
         (inherit-map (make-hash-table :test #'equal))
         (member
          (vector
           "m" "field_update_list(" "$voice_device_id, $set_field_arr"
           "0:10" "int" class "public" ""
           (concat
            "array{'sn': string}|array{'voice_device_id': int}|int "
            "$voice_device_id, array{'tenant_id'?: int, "
            "'net_type'?: int|null, ...<int, string>} $set_field_arr")))
         (tags (list class-map function-map inherit-map [] "/project/"))
         (content
          (concat
           "<?php\nfunction run(" class " $device) {\n"
           "  $device->field_update_list(1, [\"|CURSOR|\"]);\n}")))
    (puthash class (vector member) class-map)
    (puthash class (vector "c" class "" "0:1" class) function-map)
    (should
     (equal (ac-php-test--array-shape-candidates content 'core tags)
            '("tenant_id" "net_type")))))

(provide 'ac-php-array-shape-test)
;;; ac-php-array-shape-test.el ends here
