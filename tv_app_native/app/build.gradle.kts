plugins {
    id("com.android.application")
    id("org.jetbrains.kotlin.android")
}

android {
    namespace = "ir.talalive.tv"
    compileSdk = 34
    buildToolsVersion = "35.0.0"

    defaultConfig {
        applicationId = "ir.talalive.tv"
        minSdk = 21
        targetSdk = 34
        versionCode = 3
        versionName = "2.0.1"
    }

    buildFeatures {
        buildConfig = true
    }

    signingConfigs {
        create("release") {
            val ksPath = System.getenv("TALA_KEYSTORE_PATH") ?: "../../keystore/talalive-tv-release.jks"
            storeFile = file(ksPath)
            storePassword = System.getenv("TALA_KEYSTORE_PASSWORD")
            keyAlias = System.getenv("TALA_KEY_ALIAS") ?: "talalive"
            keyPassword = System.getenv("TALA_KEY_PASSWORD")
        }
    }

    buildTypes {
        release {
            isMinifyEnabled = true
            isShrinkResources = true
            proguardFiles(getDefaultProguardFile("proguard-android-optimize.txt"), "proguard-rules.pro")
            signingConfig = signingConfigs.getByName("release")
        }
        debug {
            // Default Android debug signing
        }
    }

    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_1_8
        targetCompatibility = JavaVersion.VERSION_1_8
    }
    kotlinOptions {
        jvmTarget = "1.8"
    }
}

dependencies {
    // هیچ وابستگی‌ای اضافه نکن. D-01.
    implementation("org.jetbrains.kotlin:kotlin-stdlib:2.0.0")
}
