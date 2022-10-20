/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : PostgreSQL
 Source Server Version : 110003
 Source Host           : localhost:5432
 Source Catalog        : gotest
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 110003
 File Encoding         : 65001

 Date: 20/10/2022 17:19:39
*/


-- ----------------------------
-- Table structure for send_emails
-- ----------------------------
DROP TABLE IF EXISTS "public"."send_emails";
CREATE TABLE "public"."send_emails" (
  "id" int4 NOT NULL DEFAULT nextval('send_emails_id_seq'::regclass),
  "email" varchar(255) COLLATE "pg_catalog"."default",
  "user_id" int4,
  "message" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of send_emails
-- ----------------------------
INSERT INTO "public"."send_emails" VALUES (2, 'dani.nugrahadi@gmail.com', 1, 'test message');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "public"."users";
CREATE TABLE "public"."users" (
  "id" int4 NOT NULL DEFAULT nextval('users_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "email" varchar(255) COLLATE "pg_catalog"."default",
  "email_verified_at" timestamp(0),
  "password" varchar(255) COLLATE "pg_catalog"."default",
  "remember_token" varchar(100) COLLATE "pg_catalog"."default",
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
)
;
