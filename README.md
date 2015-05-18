# Yii2 select2 widget.

Select2 widget is a wrapper of [Select2](https://select2.github.io/) for Yii 2 framework.

## Install

```
php composer.phar require --prefer-dist consultnn/yii2-select2 "*"
```

or add to `composer.json`

```
"consultnn/yii2-select2": "*"
```

## Usage

```
echo $form->field($model, 'field')->widget(\consultnn\select2\Select2::className());
```
