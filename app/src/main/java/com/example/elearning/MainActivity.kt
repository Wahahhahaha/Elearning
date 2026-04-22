package com.example.elearning

import android.graphics.Bitmap
import android.os.Bundle
import android.view.View
import android.view.WindowManager
import android.webkit.WebResourceRequest
import android.webkit.WebView
import android.webkit.WebViewClient
import android.widget.ProgressBar
import androidx.activity.enableEdgeToEdge
import androidx.activity.OnBackPressedCallback
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.core.content.ContextCompat
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat
import java.io.IOException
import java.text.SimpleDateFormat
import java.util.Date
import java.util.Locale

class MainActivity : AppCompatActivity() {

    private lateinit var webView: WebView
    private lateinit var progressBar: ProgressBar
    private var screenCaptureCallback: android.app.Activity.ScreenCaptureCallback? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        window.setFlags(
            WindowManager.LayoutParams.FLAG_SECURE,
            WindowManager.LayoutParams.FLAG_SECURE
        )
        enableEdgeToEdge()
        setContentView(R.layout.activity_main)
        setupScreenCaptureDetection()

        // Inisialisasi View
        webView = findViewById(R.id.webView)
        progressBar = findViewById(R.id.progressBar)

        // Konfigurasi WebView
        webView.settings.javaScriptEnabled = true
        webView.settings.domStorageEnabled = true

        // Implementasi WebViewClient dengan Loading State
        webView.webViewClient = object : WebViewClient() {
            override fun shouldOverrideUrlLoading(
                view: WebView?,
                request: WebResourceRequest?
            ): Boolean {
                val nextUrl = request?.url?.toString() ?: return false
                view?.loadUrl(nextUrl)
                return true
            }

            override fun onPageStarted(view: WebView?, url: String?, favicon: Bitmap?) {
                super.onPageStarted(view, url, favicon)
                // Munculkan progress bar saat mulai loading
                progressBar.visibility = View.VISIBLE
            }

            override fun onPageFinished(view: WebView?, url: String?) {
                super.onPageFinished(view, url)
                // Sembunyikan progress bar saat selesai loading
                progressBar.visibility = View.GONE
            }
        }

        // Memuat URL (Isi dengan URL tujuanmu)
        webView.loadUrl("https://elsph.permataharapanku.sch.id/")

        // Agar tombol back menavigasi history WebView dulu
        onBackPressedDispatcher.addCallback(this, object : OnBackPressedCallback(true) {
            override fun handleOnBackPressed() {
                if (webView.canGoBack()) {
                    webView.goBack()
                } else {
                    isEnabled = false
                    onBackPressedDispatcher.onBackPressed()
                }
            }
        })

        // Pengaturan Edge-to-Edge Padding
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main)) { v, insets ->
            val systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars())
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom)
            insets
        }
    }

    private fun setupScreenCaptureDetection() {
        if (android.os.Build.VERSION.SDK_INT < android.os.Build.VERSION_CODES.UPSIDE_DOWN_CAKE) {
            return
        }

        val callback = android.app.Activity.ScreenCaptureCallback {
            onScreenCaptureDetected("Upaya screenshot/screen record terdeteksi")
        }
        screenCaptureCallback = callback
        registerScreenCaptureCallback(ContextCompat.getMainExecutor(this), callback)
    }

    private fun onScreenCaptureDetected(message: String) {
        appendCaptureHistory(message)
        if (!isFinishing && !isDestroyed) {
            AlertDialog.Builder(this)
                .setTitle("Peringatan Keamanan")
                .setMessage("Screenshot atau screen recording tidak diizinkan pada halaman ini.")
                .setPositiveButton("OK", null)
                .show()
        }
    }

    private fun appendCaptureHistory(event: String) {
        val timestamp = SimpleDateFormat("yyyy-MM-dd HH:mm:ss", Locale.getDefault()).format(Date())
        val entry = "$timestamp | $event"
        try {
            openFileOutput("capture_history.log", MODE_APPEND).bufferedWriter().use { writer ->
                writer.appendLine(entry)
            }
        } catch (_: IOException) {
        }
    }

    override fun onDestroy() {
        if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.UPSIDE_DOWN_CAKE) {
            screenCaptureCallback?.let { unregisterScreenCaptureCallback(it) }
        }
        webView.destroy()
        super.onDestroy()
    }
}
