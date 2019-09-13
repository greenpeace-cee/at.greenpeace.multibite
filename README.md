# CiviCRM Multibite Extension 😲

This CiviCRM extension adds a workaround for the inbound email processor
dropping or truncating emails that contain certain multi-byte characters such
as emojis by replacing it with the Unicode replacement character `�`.

The Multibite extension is obsolete once CiviCRM
[supports the `utf8mb4` character set](https://lab.civicrm.org/dev/core/issues/339).
A work-in-progress patch for `utf8mb4` [is available as an alternative to this extension](https://github.com/civicrm/civicrm-core/pull/13633).

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.1+
* CiviCRM 5.13+

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl at.greenpeace.multibite@https://github.com/greenpeace-cee/at.greenpeace.multibite/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/greenpeace-cee/at.greenpeace.multibite.git
cv en multibite
```

## Usage

After installing the extension, all 4-byte UTF-8 sequences (which are not
supported by the `utf8` MySQL character set) in the `subject` and `details`
fields of any new "Inbound Email" activity are replaced with the Unicode
replacement character `�` before they're stored in the database.

The extension performs the same replacement on any text mail parts that go
through the `hook_civicrm_emailProcessor` hook.  This does not affect CiviCRM
by itself, but ensures that other extensions that implement
`hook_civicrm_emailProcessor` receive mail objects that are consistent with
what CiviCRM stored in the database.

The replacement character defaults to `�` and can be changed via the
`multibite_replacement_character` extension setting.
